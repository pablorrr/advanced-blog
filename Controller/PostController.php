<?php

namespace Controller;

use Libs\Valid;
use Model\CommentModel;
use Model\PostModel;

/**
 * Class PostController
 * @package Controller
 */
class PostController extends MainController
{
    /**
     * @var array
     */
    protected array $oPosts;

    protected $oPost;
    /**
     * @var PostModel
     */
    public PostModel $PostModel;
    /**
     * @var CommentModel
     */
    protected CommentModel $CommentModel;

    /**
     * PostController constructor.
     * @param PostModel $PostModel
     * @param CommentModel $CommentModel
     */
    public function __construct(PostModel $PostModel, CommentModel $CommentModel)
    {
        // Enable PHP Session
        if (empty($_SESSION))
            session_start();
        $this->PostModel = $PostModel;
        $this->CommentModel = $CommentModel;
    }

    use Valid;

    public function getMainPage()
    {
        $this->oPosts = $this->PostModel->getAll();
        $this->getView('blog/index');
    }

    /**
     * @param $post_id
     */
    public function getSinglePost($post_id)
    {
        $this->oPost = $this->PostModel->getById($post_id);
        $this->getView('blog/single-post');
    }


    /**
     *  dodoanie posta
     */
    public function add_get()
    {
        if (!$this->isLogged()) exit;
        $this->getView('blog/add-post');
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

                if ($this->PostModel->add($aData)) {

                    header('Location: ' . ROOT_URL);
                    $_SESSION['PostSuccessMsg'] = 'Hurray!! The post has been added.';

                } else {
                    header('Location: ' . ROOT_URL . '/add');
                    $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
                }

            } else {

                header('Location: ' . ROOT_URL . '/add');
                $_SESSION['PostErrorMsg'] = 'All fields are required and the title cannot exceed 50 characters.';
            }
        }

    }

    /**
     * @param $post_id
     */
    public function edit_get($post_id)
    {
        if (!$this->isLogged()) exit;

        /* Get the data of the post */
        //todo: sprawdz czy nie wystepuje niepotr\zbny duplikat getbyid
        $this->oPost = $this->PostModel->getById($post_id);

        $this->getView('blog/edit-post');
    }

    /**
     * @param $post_id
     */
    public function edit_post($post_id)
    {
        if (!$this->isLogged()) exit;

        $this->oPost = $this->PostModel->getById($post_id);
        //** EDIT WHEN NO COMMENTS**//
        if (!empty($_POST['edit_submit'])) {

            if (isset($_POST['title'], $_POST['body'])
                && preg_match('/^[a-zA-Z ]*$/', $_POST['title'])
                && preg_match('/^[a-zA-Z ]*$/', $_POST['body'])) {
                //todo zaminiec na preg replace


                $aData = array('post_id' => self::test_input($post_id),
                    'title' => self::test_input($_POST['title']),
                    'body' => self::test_input($_POST['body']));

                if ($this->PostModel->update($aData)) {

                    header('Location: ' . ROOT_URL);
                    $_SESSION['PostSuccessMsg'] = 'Hurray!! The post has been updated.';

                } else {

                    header('Location: ' . ROOT_URL . '/edit?id=' . $post_id);
                    $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later';
                }

            } else {

                header('Location: ' . ROOT_URL . '/edit?id=' . $post_id);
                $_SESSION['PostErrorMsg'] = 'All fields are required and only letters allowed.';
            }

            //** EDIT WHEN THERE ARE COMMENTS**//
            if (isset($_POST['title'], $_POST['body'], $_POST['comment'])) {

                //only letter allowed must  contain  min two word
                if (preg_match('/^[a-zA-Z ]*$/', $_POST['title'])
                    && preg_match('/^[a-zA-Z ]*$/', $_POST['body'])
                    && preg_match('/^[a-zA-Z ]*$/', $_POST['comment'])) {

                    $aData = array('post_id' => self::test_input($post_id),
                        'title' => self::test_input($_POST['title']),
                        'body' => self::test_input($_POST['body']));

                    $CommentData = array('post_id' => self::test_input($post_id),
                        'comment' => self::test_input($_POST['comment'])
                    );

                    if (($this->PostModel->update($aData)) && ($this->CommentModel->update($CommentData))) {

                        header('Location: ' . ROOT_URL);
                        $_SESSION['PostSuccessMsg'] = 'Hurray! The post and comment has been updated.';

                    } else {

                        header('Location: ' . ROOT_URLL . '/edit?id=' . $post_id);
                        $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later';
                    }

                } else {

                    header('Location: ' . ROOT_URL . '/edit?id=' . $post_id);
                    $_SESSION['PostErrorMsg'] = 'Whoops! An error has occurred! Please try again later';
                }
            }
        }


    }

    /**
     * @param $post_id
     */
    public function delete($post_id)
    {
        if (!$this->isLogged()) exit;


        //when comments exists
        if ($this->CommentModel->getByIdCheck($post_id)) {

            if (!empty($_POST['delete'])
                && $this->PostModel->delete($post_id)
                && $this->CommentModel->delete($post_id)) {

                header('Location: ' . ROOT_URL);
            } else {
                exit('Whoops! Post cannot be deleted.');
            }

        }
        //when comments not exists
        if (!$this->CommentModel->getByIdCheck($post_id)) {
            if ((!empty($_POST['delete'])) && ($this->PostModel->delete($post_id))) {
                header('Location: ' . ROOT_URL);
            } else {
                exit('Whoops! Post cannot be deleted.');
            }

        }
    }

    public function api_posts()
    {
        $this->oPosts = $this->PostModel->getAll();
        if (empty($this->oPosts)) exit();
        echo json_encode($this->oPosts);
    }

}