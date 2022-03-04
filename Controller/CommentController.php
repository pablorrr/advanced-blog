<?php

namespace Controller;

use Libs\Valid;


class CommentController extends MainController
{
//todo : sprawdz czy ta zmienna jest potrzebna!!
    private $_iId;
    private $PostModel;
    private $CommentModel;


    public function __construct($PostModel, $CommentModel)
    {
        // Enable PHP Session
        if (empty($_SESSION))
            @session_start();

        $this->PostModel = $PostModel;
        $this->CommentModel = $CommentModel;
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
        $this->getView('add_comment');
    }

}