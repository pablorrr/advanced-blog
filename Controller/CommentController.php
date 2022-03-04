<?php

namespace Controller;

use Libs\Valid;

class Comment extends MainController
{

    protected $oModel;
    private $_iId;
    public $oComments;
    protected $BlogModel;
    protected $CommentModel;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        // Enable PHP Session
        if (empty($_SESSION))
            @session_start();


        /** Get the Model class in all the controller class **/

        $this->getModel('Comment');
        $this->oModel = new \PhpMVC\Model\Comment;

        /** Get the Comment ID in the constructor in order to avoid the duplication of the same code **/
        $this->_iId = (int)(!empty($_GET['id']) ? $_GET['id'] : 0);

        $this->BlogModel = new \PhpMVC\Model\Blog();
        $this->CommentModel = new \PhpMVC\Model\Comment();


    }


    /***** Front end *****/

    /**
     * trait usage
     */
    use Valid;

    public function add()
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

        if (!empty($_POST['add_comment'])) {

            if (isset($_POST['comment'], $_POST['post_id']) && mb_strlen($_POST['comment']) <= 250
                && preg_match('/([a-zA-Z]+( [a-zA-Z]+)+)/i', $_POST['comment']) ){

                $aData = array(
                    'comment' => self::test_input($_POST['comment']),
                    'post_id' => self::test_input($_POST['post_id'])
                );

            /**      if add         */

            if ($this->oModel->add($aData)) {

                header('Location: ' . ROOT_URL);

                if (!empty($_SESSION['CommentErrorMsg'])) {
                    unset($_SESSION['CommentErrorMsg']);
                }

                $_SESSION['CommentSuccessMsg'] = 'Hurray!! The comment has been added.';

            } else {

                if (!empty($_SESSION['CommentSuccessMsg'])) {
                    unset($_SESSION['CommentSuccessMsg']);
                }

                $_SESSION['CommentErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
            }

            /**     end if add         */

        }else{
                if (!empty($_SESSION['CommentSuccessMsg'])) {
                    unset($_SESSION['CommentSuccessMsg']);
                }

                $_SESSION['CommentErrorMsg'] = 'All fields are required  cannot exceed 250 characters and must be leettes and contains twosingle separated words .';
            }
        }//add comment if
        $this->getView('add_comment');
    }


    protected
    function isLogged()
    {
        return !empty($_SESSION['is_logged']);
    }
}