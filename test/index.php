<?php
error_reporting(E_ALL);
require '../router.class.php';
require 'controller.php';

$router = new Router;
$Controller = new Controller;

//$router->setBase('/base');
/*echo $_SERVER['QUERY_STRING'].'<br>';//dla url http://simplyrouter.test/?r=9 ,print r=9

echo  $_SERVER['REQUEST_METHOD'].'<br>';//zwroci metode przesyly get lub post dla zwyklej strony bez formlarza zawsze get

echo $_SERVER['PATH_INFO']. '<br>';//error gdy jest  sam url bez uri , dla http://simplyrouter.test/example/test/?r=9 zwroci /example/test/

echo $_SERVER['SCRIPT_NAME'].'<br>';///index.php

echo $_SERVER['PHP_SELF'].'<br>';///index.php*/

/**
 * ustalenie bazowego uri przy zlozonych uri
 *
 *  w tym przypadku zadzilaja tylko  uri np /base/my/route ,base/hello/world
 *
 *
 */
//$router->setBase('/base');
/**
 * my route
 */

$router->get('/base/base', array(
    'func' => 'Controller::baseroute'
));//error nie zadzila

$router->get('/my/route', array(
    'func' => 'Controller::myroute'
));

$router->get('/hello/world', array(
	'func' => 'Controller::helloworld'
));

$router->get('/text', array(
	'func' => array($Controller, 'text'),
	'parameters' => array(1, 2, 3)
));

$router->get('/phpinfo', 'phpinfo');

$router->get('/ec+h(o)', function(){
	echo $_GET['t'];
});

//zwraca sciezke z parametrami - przykladowe zasyosowanie - http://simplyrouter.test/patextth
//zwoci -Current Path:/patextth
//Current Path with parameters:/patextth
//http://simplyrouter.test/pa_nazwa_sciezki_th

//jest  to helper

$router->get('/pa\*th', array(
	'func' => array($Controller, 'path'),
	'parameters' => array($router->get_URL(), $router->get_URL(true))
));

//to ssmo co wyzej ,sposob uzycia nieznany
//jest to helper
$router->get('/path(opt)', array(
	'func' => array($Controller, 'path'),
	'parameters' => array($router->get_URL(), $router->get_URL(true))
));


//zwaca informacje ze wprowadzony param jest cyfra
//uzycie http://simplyrouter.test/3 - zwroci number
$router->get('/^\/\d+$/', function(){
	echo 'number';
});

$router->get('/form', array(
	'func' => array($Controller, 'form_get')
));

$router->post('/form', array(
	'func' => array($Controller, 'form_post')
));
//pokazanie w jaki spsosb przekazywac parametry do url uri
// sposb uzycia http://simplyrouter.test/para/1/3/56/6
/**
 *
 * via get_URL_parameter():
var1:1
var2:3
var3:56
var4:6
via closure parameters:
var1:1
var2:3
var3:56
var4:6
 *
 *
 */
$router->get('/para/{var1}/{var2}/{var3}/{var4}', function($var1, $var2, $var3, $var4){
    global $router;
    echo 'via get_URL_parameter():';
    echo '<br>var1:' .$router->get_URL_parameter('var1');
    echo "<br>var2:" .$router->get_URL_parameter('var2');
    echo "<br>var3:" .$router->get_URL_parameter('var3');
    echo "<br>var4:" .$router->get_URL_parameter('var4');

    echo '<br>via closure parameters:';
    echo '<br>var1:' .$var1;
    echo "<br>var2:" .$var2;
    echo "<br>var3:" .$var3;
    echo "<br>var4:" .$var4;
});

$router->catch_exception(function(){
	echo 'no suitable routing pattern';
});

$router->match();