<?php

namespace Controller;

use Libs\Valid;
use Model\PostModel;
use Model\CommentModel;

class CommentController extends MainController
{

    protected $oModel;
    private $_iId;
    public $oComments;
    protected $BlogModel;
    protected $CommentModel;
    protected $oPost;
    /**
     * @var PostModel
     */
    private $PostModel;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        // Enable PHP Session
        if (empty($_SESSION))
            @session_start();


        /** Get the Model class in all the controller class **/

        // $this->getModel('CommentModel');
        //  $this->oModel = new CommentController();

        /** Get the Comment ID in the constructor in order to avoid the duplication of the same code **/
        //  $this->_iId = (int)(!empty($_GET['id']) ? $_GET['id'] : 0);

        $this->PostModel = new PostModel();
        $this->CommentModel = new CommentModel();


    }


    /***** Front end *****/

    /**
     * trait usage
     */
    use Valid;


    public function add_post($post_id)
    {
        if (!empty($_SESSION['PostSuccessMsg'])) {
            unset($_SESSION['PostSuccessMsg']);
        }

        if (empty($_POST['add_comment'])): if (!empty($_SESSION['CommentSuccessMsg'])) {
            unset($_SESSION['CommentSuccessMsg']);
        }
        endif;

        if (empty($_POST['add_comment'])): if (!empty($_SESSION['CommentErrorMsg'])) {
            unset($_SESSION['CommentErrorMsg']);
        }
        endif;

        // $this->oPost = $this->PostModel->getById($post_id);

        if (!empty($_POST['add_comment'])) {

            if (isset($_POST['comment'])
                && mb_strlen($_POST['comment']) <= 250
                && preg_match('/([a-zA-Z]+( [a-zA-Z]+)+)/i', $_POST['comment'])) {

                $aData = array(
                    'comment' => self::test_input($_POST['comment']),
                    'post_id' => $post_id,
                );

                /**      if add         */

                if ($this->CommentModel->add($aData)) {

                    header('Location: ' . MAIN_PAGE);

                    if (!empty($_SESSION['CommentErrorMsg'])) {
                        unset($_SESSION['CommentErrorMsg']);
                    }

                    $_SESSION['CommentSuccessMsg'] = 'Hurray!! The comment has been added.';

                } else {

                    header('Location: ' . MAIN_ROOT_URL . '/add-comment?id=' . $post_id);

                    if (!empty($_SESSION['CommentSuccessMsg'])) {
                        unset($_SESSION['CommentSuccessMsg']);
                    }

                    $_SESSION['CommentErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
                }

                /**     end if add         */

            } else {

                header('Location: ' . MAIN_ROOT_URL . '/add-comment?id=' . $post_id);

                if (!empty($_SESSION['CommentSuccessMsg'])) {
                    unset($_SESSION['CommentSuccessMsg']);
                }

                $_SESSION['CommentErrorMsg'] = 'All fields are required  cannot exceed 250 characters and must be leettes and contains two single separated words .';
            }
        }//add comment if

    }

    public function add_get()
    {

        //    $this->oPost = $this->PostModel->getById($post_id);
        $this->getView('add_comment');

    }



    //  protected
    //   function isLogged()
    // {
    //       return !empty($_SESSION['is_logged']);
    //   }
}