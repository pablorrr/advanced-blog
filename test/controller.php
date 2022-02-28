<?php

require 'MainController.php';
//require 'MainModel.php';
require 'BlogModel.php';

class Controller extends MainController
{
    /**
     * @var array
     */
    protected $oPosts;
    protected $oPost;
    protected $oModel;

    public function __construct()
    {
        // Enable PHP Session
        //  if (empty($_SESSION))
        //  session_start();


        $this->oModel = new BlogModel();

        /** Get the Post ID in the constructor in order to avoid the duplication of the same code **/
        $this->_iId = (int)(!empty($_GET['id']) ? $_GET['id'] : 0);


    }


    /******************* Test Zone *****************************/
//uwaga!!! nie mozna nzwac metody i route index jest to njprwd nazwa zastrzezona!!!!
    public function getMainPage()
    {
        $this->oPosts = $this->oModel->getAll();

        $this->getView('index');
    }


    public function getSinglePost($post_id)
    {    echo 'Current post id: ' . $post_id;
        // var_dump(  $router->get_URL_parameter('var1'));
          $this->oPost = $this->oModel->getById($post_id);

        $this->getView('single-post');



    }

    /*******************  End Test Zone *****************************/


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


}