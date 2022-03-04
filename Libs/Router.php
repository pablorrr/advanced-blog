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

        if (substr($this->url, 0, strlen($base)) == $base) {
            $this->url = substr($this->url, strlen($base));
        } else {
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
            return $this->base . $this->url;
        } else {

            return (($_SERVER['QUERY_STRING'] != null) ? '?' . $_SERVER['QUERY_STRING'] : '');
        }
    }

    /**
     * @param bool $parameters
     * @return int|string
     *
     * my individual modif to simply get post id toprint in single post page view
     */
    public function getId($parameters = false)
    {
        if (!$parameters) {
            return $this->base . $this->url;
        } elseif (isset($_GET['id'])) {
            return (($_GET['id'] != null) ? (int)$_GET['id'] : '');
        }
    }

    /**
     * @return bool
     **
     */

    public function match()
    {
        if (!$this->matched) {

            foreach ($this->router as $r) {
                if ($r['method'] == $_SERVER['REQUEST_METHOD']) {//spr. czy istnije wymagane zadanie get lub post

                    if (preg_match_all($this->create_regex_payload($r['path']), $this->url, $matches)) {

                        if (count($matches) > 1 && strpos($r['path'], "{")) {
                            $this->parse_url_parameters($r['path'], $matches);
                        }
                        $this->execute_func($r['exec']);
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
        if (substr($path, 0, 4) == "/^\/" && substr($path, -1, 1) == "/") { // regex
            return $path;
        }

        $strreplace = array(
            "\*" => "[\w]*",
            '/' => '\/'
        );


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
        }

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

        call_user_func_array($exec['func'], $exec['parameters']);
    }


    private function gen_url()
    {
        $url = '';//wyczyszczenie url

        if (isset($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } else {
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

        preg_match_all("/{(.*?)}/", $pattern, $para);
        for ($i = 0; $i < count($para[1]); $i++) {
            $array[] = $matches[$i + 1][0];
            $this->parameters[$para[1][$i]] = $matches[$i + 1][0];
        }
    }
}