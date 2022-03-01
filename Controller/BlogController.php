<?php

namespace Controller;

use Libs\Valid;
use Model\BlogModel;


class BlogController extends MainController
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
        if (empty($_SESSION))
            session_start();

        $this->oModel = new BlogModel();//todo: wprowadzic DI
    }

    use Valid;

    /******************* Test Zone *****************************/


    public function getMainPage()
    {
        $this->oPosts = $this->oModel->getAll();

        $this->getView('index');
    }


    public function getSinglePost($post_id)
    {
        $this->oPost = $this->oModel->getById($post_id);
        $this->getView('single-post');
    }


    /**
     *  dodoanie posta
     */
    public function add_post_get()
    {
        if (!$this->isLogged()) exit;
        $this->getView('add_post');
    }

    public function add_post_post()
    {

        if (!$this->isLogged()) exit;

        //to prevent display msg  when it is unconcern
        MainController::manageNotif();


        if (!empty($_POST['add_submit'])) {

            if (isset($_POST['title'], $_POST['body']) && mb_strlen($_POST['title']) <= 50) {

                if (preg_match('/^[a-zA-Z ]*$/', $_POST['title'])
                    && preg_match('/^[a-zA-Z ]*$/', $_POST['body'])) {


                    $aData = array('title' => self::test_input($_POST['title']),
                        'body' => self::test_input($_POST['body']),
                        'created_date' => date('Y-m-d H:i:s'));

                    if ($this->oModel->add($aData)) {

                        header('Location: ' . MAIN_PAGE);
                        $_SESSION['PostSuccessMsg'] = 'Hurray!! The post has been added.';

                    } else {
                        header('Location: ' . MAIN_PAGE . '/add');

                        if (!empty($_SESSION['PostSuccessMsg'])) {
                            unset($_SESSION['PostSuccessMsg']);
                        }

                        $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
                    }


                } else {
                    if (!empty($_SESSION['PostSuccessMsg'])) {
                        unset($_SESSION['PostSuccessMsg']);
                    }
                    $_SESSION['PostErrorMsg'] = 'Only letters allowed';
                }

            } else {
                if (!empty($_SESSION['PostSuccessMsg'])) {
                    unset($_SESSION['PostSuccessMsg']);
                }
                $_SESSION['PostErrorMsg'] = 'All fields are required and the title cannot exceed 50 characters.';
            }
        }

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