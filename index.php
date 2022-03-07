<?php

use Controller\AdminController;
use Controller\CommentController;
use Controller\PostController;

//use Controller\MainController;
use Libs\Notificator;
use Libs\Router;
use Libs\Config;
use Model\AdminModel;
use Model\CommentModel;
use Model\PostModel;

//use Controller\TestController;
// php code for logging error into a given file


require __DIR__ . '/vendor/autoload.php';

//error_reporting(E_ALL);
//disable error  warnings

error_reporting(error_reporting() & ~E_NOTICE);


define('PROT', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://');
define('ROOT_PATH', __DIR__ . '/');
define('ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))) . '/');
define('MAIN_ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))));
define('MAIN_PAGE', PROT . $_SERVER['SERVER_NAME'] . Config::MAIN_PAGE_SLUG);



//set up custom logging file
$log_file = ROOT_PATH . '/log.log';
ini_set("log_errors", TRUE);
ini_set('error_log', $log_file);




//to redirect to main page when is visit load page
if (PROT . $_SERVER['SERVER_NAME'] === MAIN_ROOT_URL) {
    header('Location: ' . MAIN_PAGE);
}


//Todo: wprowadzic klase powidomien  notyfikator w libs

$router = new Router;
$PostController = new PostController(new PostModel(), new CommentModel());
$CommentController = new CommentController(new PostModel(), new CommentModel());
$AdminController = new AdminController(new AdminModel());

//TestController::test();

//var_dump($_SESSION);


/************* Front End **********************/

/** MAIN PAGE **/

$router->get(Config::MAIN_PAGE_SLUG, array(
    'func' => array($PostController, 'getMainPage'),
    'parameters' => array()
));

$router->get('/single-post', array(
    'func' => array($PostController, 'getSinglePost'),
    'parameters' => array($router->getId(true))

));


/***************** Back End ********************/

///*** CRUD**********//
//add post
$router->get('/add', array(
    'func' => array($PostController, 'add_get')
));

$router->post('/add', array(
    'func' => array($PostController, 'add_post')
));

//edit post
//todo sprawdz czy parameters musi buyc ustwiony w dwowch miekscach edit!!

$router->get('/edit', array(
    'func' => array($PostController, 'edit_get'),
    'parameters' => array($router->getId(true))
));

$router->post('/edit', array(
    'func' => array($PostController, 'edit_post'),
    'parameters' => array($router->getId(true))
));

$router->all('/delete', array(
    'func' => array($PostController, 'delete'),
    'parameters' => array($router->getId(true))
));

//**COMMNENTS**//

//add comment
$router->get('/add-comment', array(
    'func' => array($CommentController, 'add_get')
));

$router->post('/add-comment', array(
    'func' => array($CommentController, 'add_post'),
    'parameters' => array($router->getId(true))
));

//**END COMMENTS//


//**ADMIN**//

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

$router->get('/admin/logout', array(
    'func' => array($AdminController, 'getLogoutPage')
));

//index admin (show users page)
$router->get('/admin', array(
    'func' => array($AdminController, 'index')
));


//resister user -admin
$router->get('/admin/register', array(
    'func' => array($AdminController, 'register_get')
));

$router->post('/admin/register', array(
    'func' => array($AdminController, 'register_post')
));

//edit user

$router->get('/admin/edit', array(
    'func' => array($AdminController, 'edit_get'),
    'parameters' => array($router->getId(true))
));

$router->post('/admin/edit', array(
    'func' => array($AdminController, 'edit_post'),
    'parameters' => array($router->getId(true))
));

//delete user
$router->all('/admin/delete', array(
    'func' => array($AdminController, 'delete'),
    'parameters' => array($router->getId(true))
));


//** API **//
$router->get('/api/posts', array(
    'func' => array($AdminController, 'api_posts')
));



$router->catch_exception(function () use ($PostController) {

    $PostController->getView('404');
});

$router->match();
