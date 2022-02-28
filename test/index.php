<?php
error_reporting(E_ALL);
define('PROT', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://');
define('ROOT_PATH', __DIR__ . '/');
define('ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))) . '/');


require '../router.class.php';
require 'controller.php';


$router = new Router;
$Controller = new Controller;

//$router->get('/phpinfo', 'phpinfo');
//$router->setBase('/base');


/****************** TEST ZONE***************************/

/*$router->get('/test', array(
    'func' => 'Controller::test'
));*/



$router->get('/test', array(
    'func' => array($Controller, 'test'),
    'parameters' => array()
));

/****************** END  TEST ZONE***************************/













$router->get('/my/route', array(
    'func' => 'Controller::myroute'
));

$router->get('/form', array(
    'func' => array($Controller, 'form_get')
));

$router->post('/form', array(
    'func' => array($Controller, 'form_post')
));


$router->get('/para/{var1}/{var2}/{var3}/{var4}', function ($var1, $var2, $var3, $var4) {
    global $router;
    echo 'via get_URL_parameter():';
    echo '<br>var1:' . $router->get_URL_parameter('var1');
    echo "<br>var2:" . $router->get_URL_parameter('var2');
    echo "<br>var3:" . $router->get_URL_parameter('var3');
    echo "<br>var4:" . $router->get_URL_parameter('var4');

    echo '<br>via closure parameters:';
    echo '<br>var1:' . $var1;
    echo "<br>var2:" . $var2;
    echo "<br>var3:" . $var3;
    echo "<br>var4:" . $var4;
});

$router->get('/^\/\d+$/', function () {
    echo 'number';
});

$router->get('/pa\*th', array(
    'func' => array($Controller, 'path'),
    'parameters' => array($router->get_URL(), $router->get_URL(true))
));

$router->get('/path(opt)', array(
    'func' => array($Controller, 'path'),
    'parameters' => array($router->get_URL(), $router->get_URL(true))
));
$router->get('/text', array(
    'func' => array($Controller, 'text'),
    'parameters' => array(1, 2, 3)
));
$router->catch_exception(function () {
    echo 'no suitable routing pattern';
});

$router->match();