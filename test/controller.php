<?php

require 'MainController.php';
require  'BlogModel.php';
class Controller extends MainController
{
    /**
     * @var array
     */
    protected $oPosts;

    protected $oModel;

    public function __construct()
    {
        // Enable PHP Session
      //  if (empty($_SESSION))
          //  session_start();



        $this->oModel = new BlogModel();

        /** Get the Post ID in the constructor in order to avoid the duplication of the same code **/
      //  $this->_iId = (int)(!empty($_GET['id']) ? $_GET['id'] : 0);


    }

    public static function helloworld()
    {
        echo 'Hello World';
    }

    //error nie zadzila
    public static function baseroute()
    {
        echo 'base route';
    }

    public static function myroute()
    {
        echo 'my route';
    }

//uwaga!!! nie mozna nzwac metody i route index jest to njprwd nazwa zastrzezona!!!!
    public  function test()
    {

        $this->oPosts = $this->oModel->getAll();
        $this->getView('index');
    }


    public function text($t1, $t2, $t3)
    {
        echo 'Text: ' . $t1 . $t2 . $t3;
    }

    public function path($path, $path2)
    {
        echo 'Current Path:' . $path;
        echo '<br />Current Path with parameters:' . $path2;
    }

    public function form_get()
    {
        echo '<form method="post"><input type="text" name="test" /><input type="submit" /></form>';
    }

    public function form_post()
    {
        var_dump($_POST);
    }


  /*  private static function _get($sFileName, $sType)
    {
        $sFullPath = ROOT_PATH . $sType . '/' . $sFileName . '.php';
        if (is_file($sFullPath))
            require $sFullPath;
        else
            exit('The "' . $sFullPath . '" file doesn\'t exist');
    }

    public static function getView($sViewName)
    {
        self::_get($sViewName, 'View');
    }*/


}