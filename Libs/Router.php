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
     * @param $exec
     *
     */
    public function get($path, $exec)
    {
        array_push($this->router, array('method' => 'GET', 'path' => $path, 'exec' => $this->validate_config($exec)));
    }

    /**
     * @param $path
     * @param $exec
     *
     */
    public function post($path, $exec)
    {
        array_push($this->router, array('method' => 'POST', 'path' => $path, 'exec' => $this->validate_config($exec)));
    }

    /**
     * @param $path
     * @param $exec
     *
     */
    public function all($path, $exec)
    {
        array_push($this->router, array('method' => 'GET', 'path' => $path, 'exec' => $this->validate_config($exec)));
        array_push($this->router, array('method' => 'POST', 'path' => $path, 'exec' => $this->validate_config($exec)));
    }

    /**
     * @param $exec
     *
     */
    public function catch_exception($exec)
    {
        $this->exception = $this->validate_config($exec);
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

    public function run()
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


        foreach ($strreplace as $key => $value) {

            $path = str_replace($key, $value, $path);
        }


        foreach ($pregreplace as $key => $value) {
            $path = preg_replace($key, $value, $path);
        }
        return '/^' . $path . '$/';

    }

    /**
     * @param $exec
     * @return array|callable|string|string[]
     */
    private function validate_config($exec)
    {
        if (is_callable($exec)) {//gdy exec jest closure
            $temp = $exec;
            $exec = array('func' => $temp, 'type' => 'closure');
        } elseif (is_string($exec)) {//gdy exec jest stringiem
            $temp = $exec;
            $exec = array('func' => $temp, 'type' => 'string');
        } elseif (is_string($exec['func']) && strpos($exec['func'], '::')) {
            if (!method_exists(explode('::', $exec['func'])[0], explode('::', $exec['func'])[1])) {

                trigger_error('The method specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'static';

        } elseif (is_array($exec['func']) && count($exec['func']) == 2) {
            if (!is_object($exec['func'][0])) {
                trigger_error('The first parameter of "func" should be an object', E_USER_ERROR);
            }
            if (!method_exists($exec['func'][0], $exec['func'][1])) {
                trigger_error('The method specified does not exist', E_USER_ERROR);
            }
            $exec['type'] = 'class';
        } elseif (is_string($exec['func'])) {
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

    /**
     * @param $exec
     *
     * jest to wywoalanie przypisanej akcji do url uri
     */
    private function execute_func($exec)
    {

        if ($exec['type'] == 'closure' && empty($exec['parameters'])) {
            $exec['parameters'] = $this->parameters;
        }

        call_user_func_array($exec['func'], $exec['parameters']);
    }


    private function gen_url()
    {
        $url = '';

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