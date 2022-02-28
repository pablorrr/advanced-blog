<?php

namespace Libs;

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
            // return $this->base . $this->url . (($_SERVER['QUERY_STRING'] != null) ? '?' . $_SERVER['QUERY_STRING'] : '');
            return (($_SERVER['QUERY_STRING'] != null) ? '?' . $_SERVER['QUERY_STRING'] : '');
        }
    }

    /**
     * @param bool $parameters
     * @return int|string
     *
     * my individual modif to simply get post id toprint in single post page view
     */
    public function getPostId($parameters = false)
    {
        if (!$parameters) {
            return $this->base . $this->url;//gdy nie ma parametrow zworc sceizke url bez parametrow
        } elseif (isset($_GET['id'])) {
            return (($_GET['id'] != null) ? (int)$_GET['id'] : '');
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
                     *create_regex_payload - przetwrzanie i sprawdzeie scezki urluri wedlug wyrazen regularnych
                     */

                    if (preg_match_all($this->create_regex_payload($r['path']), $this->url, $matches)) {

                        /**
                         * jesli jest wiecej niz jedno dopsowanie i w sciezce zzostanie odnlezionuy nawias klamrowy
                         * to sparsuj  parametry url
                         *
                         */
                        if (count($matches) > 1 && strpos($r['path'], "{")) {
                            $this->parse_url_parameters($r['path'], $matches);//dopsaowanie parametrow url wg wyr regularnych
                        }
                        $this->execute_func($r['exec']);//wykonannie callbacka - akcji gdy uda sie przypisanie do sciezki
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

    /**
     * @param $exec
     * @return array|callable|string|string[]
     *
     *
     */
    private function validate_config($exec)
    {//is callable - php sprawdza czt dana zmienna  moze zostac uzyta jako closure(f anonimowa)

        /**
         * $router->get('/ec+h(o)', function(){
         * echo $_GET['t'];
         * });
         * njnwprd ponizssyzy zapis sprawdza wywolania i obsluguje je jak powyzej
         *
         *
         *
         */
        if (is_callable($exec)) {//gdy exec jest closure
            $temp = $exec;
            $exec = array('func' => $temp, 'type' => 'closure');
        } elseif (is_string($exec)) {//gdy exec jest stringiem
            $temp = $exec;
            $exec = array('func' => $temp, 'type' => 'string');
        } elseif (is_string($exec['func']) && strpos($exec['func'], '::')) { //Static method
            if (!method_exists(explode('::', $exec['func'])[0], explode('::', $exec['func'])[1])) {
                //trigger_error php - printuje bledy
                trigger_error('The method specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'static';//jesli znajdzie taka metode oznacz ja jako statayczna

        } elseif (is_array($exec['func']) && count($exec['func']) == 2) { // jesli func posaida np - ($Controller, 'text'),
            if (!is_object($exec['func'][0])) {//pirewszy eleemnt  klucza func powinien byc kontrolerrem
                trigger_error('The first parameter of "func" should be an object', E_USER_ERROR);
            }
            if (!method_exists($exec['func'][0], $exec['func'][1])) {//jesli metoda nie istnije wkontrolerze
                trigger_error('The method specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'class';//jesli warunki sa spelrnione to nastaw  akcje na typ class
        } /**
         *
         * $router->get('/phpinfo', 'phpinfo');
         *
         * ponizszy zapis obsluguje njpwrd to co jest poodbne to tego co jest powyzej
         * sa to wszytko metody wbudowane w php nie wystepujace w kontrolerze
         * i nie bedace jednoczesnie wolnostojacymi poza kontrolerrem
         * metodami
         *
         *
         *
         *
         */

        elseif (is_string($exec['func'])) { //Function
            if (!function_exists($exec['func'])) {
                trigger_error('The function specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'function';//jesli istnieje funkcaj metoda wbud w php to nadaj jej typ function
        } else {
            trigger_error('The router cannot recognize the function name', E_USER_ERROR);
        }
//gdy istnieja parametry to dodoaj je do indexu parameters tablicy exec
        $exec['parameters'] = isset($exec['parameters']) ? (array)$exec['parameters'] : array();

        return $exec;//zwroc tablice akcji z ewentualnymi parametrami
    }

    /**
     * @param $exec
     *
     * jest to wywoalanie przypisanej akcji do url uri
     */
    private function execute_func($exec)
    {
        //jesli typ metody(akcji) jest closure to przypisz mu odpowiednie parametry
        if ($exec['type'] == 'closure' && empty($exec['parameters'])) {
            $exec['parameters'] = $this->parameters;
        }

        //call_user_func_array - wywoluje callback z parametrami z tablicy
        //1 par callbacj
        //2. tablica z parametrami

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

    /**
     * @param $pattern
     * @param $matches
     *
     * parsowanie paramtrow  w url
     *
     */
    private function parse_url_parameters($pattern, $matches)
    {
        //sprawdzeni paramtrow czy pasuja dopodanego wzorca i pozbeirnaie dopasowanych wynikow do tablicy
        preg_match_all("/{(.*?)}/", $pattern, $para);
        for ($i = 0; $i < count($para[1]); $i++) {
            $array[] = $matches[$i + 1][0];
            $this->parameters[$para[1][$i]] = $matches[$i + 1][0];
        }
    }
}