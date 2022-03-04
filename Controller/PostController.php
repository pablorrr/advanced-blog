<?php

namespace Controller;

use Libs\Valid;
use Model\PostModel;


class PostController extends MainController
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

        $this->oModel = new PostModel();//todo: wprowadzic DI
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
    public function add_get()
    {

        if (!$this->isLogged()) exit;
        $this->getView('add_post');
    }

    public function add_post()
    {
        if (!$this->isLogged()) exit;

        if (!empty($_POST['add_submit'])) {

            if (isset($_POST['title'], $_POST['body'])
                && mb_strlen($_POST['title']) <= 50
                && preg_match('/^[a-zA-Z ]*$/', $_POST['body'])
                && preg_match('/^[a-zA-Z ]*$/', $_POST['title'])) {

                $aData = array('title' => self::test_input($_POST['title']),
                    'body' => self::test_input($_POST['body']),
                    'created_date' => date('Y-m-d H:i:s'));

                if ($this->oModel->add($aData)) {

                    header('Location: ' . MAIN_PAGE);
                    $_SESSION['PostSuccessMsg'] = 'Hurray!! The post has been added.';

                } else {
                    header('Location: ' . MAIN_ROOT_URL . '/add');

                    if (!empty($_SESSION['PostSuccessMsg'])) {
                        unset($_SESSION['PostSuccessMsg']);
                    }

                    $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
                }

            } else {
                if (!empty($_SESSION['PostSuccessMsg'])) {
                    unset($_SESSION['PostSuccessMsg']);
                }
                header('Location: ' . MAIN_ROOT_URL . '/add');
                $_SESSION['PostErrorMsg'] = 'All fields are required and the title cannot exceed 50 characters.';
            }
        }

    }

    public function edit_get($post_id)
    {
        if (!$this->isLogged()) exit;


        /* Get the data of the post */
        //todo: sprawdz czy nie wystepuje niepotr\zbny duplikat getbyid
        $this->oPost = $this->oModel->getById($post_id);

        $this->getView('edit_post');
    }


    public function edit_post($post_id)
    {
        if (!$this->isLogged()) exit;

        $this->oPost = $this->oModel->getById($post_id);

        if (!empty($_POST['edit_submit'])) {

            if (isset($_POST['title'], $_POST['body'])
                && preg_match('/^[a-zA-Z ]*$/', $_POST['title'])
                && preg_match('/^[a-zA-Z ]*$/', $_POST['body'])) {
                //todo zaminiec na preg replace


                $aData = array('post_id' => $post_id,
                    'title' => self::test_input($_POST['title']),
                    'body' => self::test_input($_POST['body']));

                if ($this->oModel->update($aData)) {

                    header('Location: ' . MAIN_PAGE);
                    if (!empty($_SESSION['PostErrorMsg'])) {
                        unset($_SESSION['PostErrorMsg']);
                    }
                    $_SESSION['PostSuccessMsg'] = 'Hurray!! The post has been updated.';

                } else {

                    header('Location: ' . MAIN_ROOT_URL . '/edit?id=' . $post_id);
                    if (!empty($_SESSION['PostSuccessMsg'])) {
                        unset($_SESSION['PostSuccessMsg']);
                    }
                    $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later';
                }

            } else {

                header('Location: ' . MAIN_ROOT_URL . '/edit?id=' . $post_id);
                if (!empty($_SESSION['PostSuccessMsg'])) {
                    unset($_SESSION['PostSuccessMsg']);
                }
                $_SESSION['PostErrorMsg'] = 'All fields are required and only letters allowed.';
            }
        }
    }


    public function delete($post_id)
    {
        if (!$this->isLogged()) exit;

        //to prevent display msg when it is unconcern

        if (!empty($_SESSION['CommentSuccessMsg'])) {
            unset($_SESSION['CommentSuccessMsg']);
        }

        if (!empty($_SESSION['PostSuccessMsg'])) {
            unset($_SESSION['PostSuccessMsg']);
        }

        if (!empty($_SESSION['PostErrorMsg'])) {
            unset($_SESSION['PostErrorMsg']);
        }


        if ((!empty($_POST['delete'])) && ($this->oModel->delete($post_id))) {

            header('Location: ' . MAIN_PAGE);
            if (!empty($_SESSION['PostErrorMsg'])) {
                unset($_SESSION['PostErrorMsg']);
            }
            $_SESSION['PostSuccessMsg'] = 'Hurray!! The post has been deleted.';
        } else {
            header('Location: ' . MAIN_PAGE);
            if (!empty($_SESSION['PostSuccessMsg'])) {
                unset($_SESSION['PostSuccessMsg']);
            }
            $_SESSION['PostErrorMsg'] = 'The post cant be deleted.';
        }

        //  exit('Whoops! Post cannot be deleted.');
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