<?php

use Controller\AdminController;
use Controller\BlogController;
use Controller\MainController;
use Libs\Router;
use Libs\Config;

//use Controller\TestController;

require __DIR__ . '/vendor/autoload.php';

//error_reporting(E_ALL);
error_reporting(error_reporting() & ~E_NOTICE);


define('PROT', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://');
define('ROOT_PATH', __DIR__ . '/');
define('ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))) . '/');
define('MAIN_ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))));
define('MAIN_PAGE', PROT . $_SERVER['SERVER_NAME'] . Config::MAIN_PAGE_SLUG);

//to redirect to main page when is visit load page
if (PROT . $_SERVER['SERVER_NAME'] === MAIN_ROOT_URL) {
    header('Location: ' . MAIN_PAGE);
}



$router = new Router;
$BlogController = new BlogController();
$AdminController = new AdminController();

//TestController::test();

//var_dump($_SESSION);
/****************** TEST ZONE***************************/

/************* Front End **********************/

/** MAIN PAGE **/

$router->get(Config::MAIN_PAGE_SLUG, array(
    'func' => array($BlogController, 'getMainPage'),
    'parameters' => array()
));

$router->get('/single-post', array(
    'func' => array($BlogController, 'getSinglePost'),
    'parameters' => array($router->getPostId(true))

));


/***************** Back End ********************/

///*** CRUD**********//
//add post
$router->get('/add', array(
    'func' => array($BlogController, 'add_get')
));

$router->post('/add', array(
    'func' => array($BlogController, 'add_post')
));

//edit post
//todo sprawdz czy parameters musi buyc ustwiony w dwowch miekscach edit!!

$router->get('/edit', array(
    'func' => array($BlogController, 'edit_get'),
    'parameters' => array($router->getPostId(true))
));

$router->post('/edit', array(
    'func' => array($BlogController, 'edit_post'),
    'parameters' => array($router->getPostId(true))
));

$router->all('/delete', array(
    'func' => array($BlogController, 'delete'),
    'parameters' => array($router->getPostId(true))
));
///***  END CRUD**********//


//login form
$router->get('/login', array(
    'func' => array($AdminController, 'login_get')
));

$router->post('/login', array(
    'func' => array($AdminController, 'login_post')
));

$router->all('/logout', array(
    'func' => array($AdminController, 'logout')
));






/****************** END  TEST ZONE***************************/


$router->get('/form', array(
    'func' => array($BlogController, 'form_get')
));

$router->post('/form', array(
    'func' => array($BlogController, 'form_post')
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


$router->get('/pa\*th', array(
    'func' => array($BlogController, 'path'),
    'parameters' => array($router->get_URL(), $router->get_URL(true))
));

$router->get('/path(opt)', array(
    'func' => array($BlogController, 'path'),
    'parameters' => array($router->get_URL(), $router->get_URL(true))
));
$router->get('/text', array(
    'func' => array($BlogController, 'text'),
    'parameters' => array(1, 2, 3)
));


$router->catch_exception(function () use ($BlogController) {

    $BlogController->getView('404');
});

$router->match();


