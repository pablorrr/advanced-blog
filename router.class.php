<?php

class Router
{
    /**
     * @var string
     */
    private $url = '';
    /**
     * @var array
     */
    private $router = array();
    /**
     * @var null
     */
    private $exception = null;
    /**
     * @var array
     */
    private $parameters = array();
    /**
     * @var string
     */
    private $base = '';
    /**
     * @var bool
     */
    private $matched = false;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->gen_url();
    }

    /**
     * @param $path //np. /my/route/
     * @param $exec //dopasowania sciezki akcja jaka ma sie wykonac za pomaca metody wywolanej z kontrolerra
     *
     * tworzy poiwiazzanie z adresem uri a podejmowana konkretna akcja zkontrolerra
     * gl;owni e sluzydo obslugi tych zadan ktore pochodza spoza formularzy
     */
    public function get($path, $exec)
    {
//tworzy tabluce router
        //get jako metoda przesylu - glownie zarezerwowana za obsluge poza formularzami
        //path jako sciezk auri
        //exec jako akca  wywolana z metody kontroleraa lub  calback w zaleznosci od sposobu wywolania metody get
        //exec jest walidowany i przetwrzany przezvalidate config

        array_push($this->router, array('method' => 'GET', 'path' => $path, 'exec' => $this->validate_config($exec)));
    }

    /**
     * @param $path
     * @param $exec
     *
     * pofonnie jak powyzej ale sluzy do obslugi forlumarzy
     */
    public function post($path, $exec)
    {
        array_push($this->router, array('method' => 'POST', 'path' => $path, 'exec' => $this->validate_config($exec)));
    }

    /**
     * @param $path
     * @param $exec
     *
     * njprwd  obsluguje obywdei metody przesylu danych - obsluga zwyklych stron jak i formulzray
     */
    public function all($path, $exec)
    {
        array_push($this->router, array('method' => 'GET', 'path' => $path, 'exec' => $this->validate_config($exec)));
        array_push($this->router, array('method' => 'POST', 'path' => $path, 'exec' => $this->validate_config($exec)));
    }

    /**
     * @param $exec
     *
     * wylpaywanie wyjatkow
     * obsluga biezacej wykonywanej akcji podejmowanie walidacji i zworcenie bledu jesli  zostal wylapany
     */
    public function catch_exception($exec)
    {
        $this->exception = $this->validate_config($exec);
    }

    /**
     * @param $base
     *
     * brak uzycia bezposredniego w aplikacji
     *
     * setbase ustali nadrzeny bazowy grupowy czlon rodzicielski wzgledny do podgrupy np /base/my/world
     *  i tylko tkasciezka bedzie  dzilac gdzie piewrwszy bedzie np base testy pokazane w pliku index
     *
     *
     *
     */
    public function setBase($base)
    {
        $this->base = $base;
//do url (uri) podstaw jako bazowa sciezke tylko wtedy gdy nie mozna z niej wyciagnc podciagu
        if (substr($this->url, 0, strlen($base)) == $base) {
            $this->url = substr($this->url, strlen($base));
        } else {//w przeciwnym wypadku otraktuj go jako zwykly uri ,url
            $this->matched = true; //Jump to exception
        }
    }

    /**
     * @param bool $parameters
     * @return string
     *
     *
     */

    public function get_URL($parameters = false)
    {
        if (!$parameters) {
            return $this->base . $this->url;//gdy nie ma parametrow zworc sceizke url bez parametrow
        } else {// w przeciwnym razie zwroc scezke z parametrami(mimo wszytsko  istnieni paramtrow i tak jest sprwdxzane)
            return $this->base . $this->url . (($_SERVER['QUERY_STRING'] != null) ? '?' . $_SERVER['QUERY_STRING'] : '');
        }
    }

    /**
     * @return bool
     *
     * njprwd nawaznjesza metoda w routingu
     * njprwd sprwdza i dopusowuje wszytskie wywolania w index.php  get potst itp do tego co zostaloodczytane z serwer url
     * i wywoluje dopsaowana do sciezki akcje w kontolerzelub w inny sposob( przyklady sa do sprawdzeia w index.php)
     *
     */

    public function match()
    {//jesli nie wykryto dopsaowania sceezki url w przegldarcez wywolaniami  route
        if (!$this->matched) {
            //iteraca wszytskich wywolania get i put (sa to tablice)
            foreach ($this->router as $r) {
                if ($r['method'] == $_SERVER['REQUEST_METHOD']) {//spr. czy istnije wymagane zadanie get lub post
                    /**
                     * preg match all wyszukuje wszytskie dopsowania i zwraca eleemnty dopssowane
                     * $this->create_regex_payload($r['path']) - wzorzec wg ktroego maja byc dopsowania
                     * $this->url - przeszukiwany lancuch
                     *$matches - zwrocone dopasowania
                     *
                     * preg all match -https://www.w3schools.com/php/phptryit.asp?filename=tryphp_func_regex_preg_match_all
                     *
                     *
                     */

                    if (preg_match_all($this->create_regex_payload($r['path']), $this->url, $matches)) {

                        /**
                         * jesli jest wiecej niz jedno dopsowanie i w sciezce zzostanie odnlezionuy nawias klamrowy
                         * to sparsuj  parametry url
                         *
                         */
                        if (count($matches) > 1 && strpos($r['path'], "{")) {
                            $this->parse_url_parameters($r['path'], $matches);
                        }
                        $this->execute_func($r['exec']);//njprwd wykonannie callbacka , przypisanej akcji do scezki np.wypisanie tekstu
                        return true;
                    }
                }
            }
        }
        //Exception
        $this->execute_func($this->exception);
        $this->matched = true;
    }

    public function get_URL_parameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        } else {
            return false;
        }
    }

    /**
     * @param $path
     * @return string
     *
     * njprwd przetrwarza sciezke oraz sprwdzajej poprawnosc wg wyrazen regularnych
     */
    private function create_regex_payload($path)
    {
        //njprwd wstepna okreslenie sceizki - wtsepne budowanie podstwowwego wyrazenia regularnego jakie ma spelniac sciezka

        if (substr($path, 0, 4) == "/^\/" && substr($path, -1, 1) == "/") { // regex
            return $path;
        }
        //tablica  do wykorzytsania przy wymianie w lancuchu
        $strreplace = array(
            "\*" => "[\w]*",
            '/' => '\/'
        );

        //tablica do wymianie w lancuchu ale zgodnie z podanycm wzrocem
        $pregreplace = array(
            "/(\([\w]+\))/" => "$1{0,1}",
            "/{[\w]+}/" => "(.*?)"
        );

        //zamina bez uzycia wyrazenia regulanego
        foreach ($strreplace as $key => $value) {

            //key - wyszukiwana wartosc(needle)
            //$value - wartosc ktrra ma zastapic wartosc wyszukiwana
            //$path - sciezka ktrama byc przeszukiwana

            $path = str_replace($key, $value, $path);
        }

        //zamiana z uzyciem wyraznei regularnego
        //dzikei temu jest mozliwe np  przetwarzaienie argumentow parematrow w url
        foreach ($pregreplace as $key => $value) {
            $path = preg_replace($key, $value, $path);
        }
        return '/^' . $path . '$/';

    }

    private function validate_config($exec)
    {
        if (is_callable($exec)) {
            $temp = $exec;
            $exec = array('func' => $temp, 'type' => 'closure');
        } elseif (is_string($exec)) {
            $temp = $exec;
            $exec = array('func' => $temp, 'type' => 'string');
        } elseif (is_string($exec['func']) && strpos($exec['func'], '::')) { //Static method
            if (!method_exists(explode('::', $exec['func'])[0], explode('::', $exec['func'])[1])) {
                trigger_error('The method specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'static';
        } elseif (is_array($exec['func']) && count($exec['func']) == 2) { //Class method
            if (!is_object($exec['func'][0])) {
                trigger_error('The first parameter of "func" should be an object', E_USER_ERROR);
            }
            if (!method_exists($exec['func'][0], $exec['func'][1])) {
                trigger_error('The method specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'class';
        } elseif (is_string($exec['func'])) { //Function
            if (!function_exists($exec['func'])) {
                trigger_error('The function specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'function';
        } else {
            trigger_error('The router cannot recognize the function name', E_USER_ERROR);
        }

        $exec['parameters'] = isset($exec['parameters']) ? (array)$exec['parameters'] : array();

        return $exec;
    }

    private function execute_func($exec)
    {
        if ($exec['type'] == 'closure' && empty($exec['parameters'])) {
            $exec['parameters'] = $this->parameters;
        }
        call_user_func_array($exec['func'], $exec['parameters']);
    }

    /**
     *  generowanie urla - jego biezacy odczyt z pasku adresu browser
     * jest to piewrwsza czynnosc routera zaraz po uruchominu apki
     */
    private function gen_url()
    {
        $url = '';//wyczyszczenie url
        //jesli istnieje  uri to stworz url zapmoco uri
        if (isset($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {//w przeciwnym razie bazuj na php self
            $url = '/' . str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']);
        }

        $url = rtrim($url, '/');

        $this->url = $url;
    }

    private function parse_url_parameters($pattern, $matches)
    {
        preg_match_all("/{(.*?)}/", $pattern, $para);
        for ($i = 0; $i < count($para[1]); $i++) {
            $array[] = $matches[$i + 1][0];
            $this->parameters[$para[1][$i]] = $matches[$i + 1][0];
        }
    }
}