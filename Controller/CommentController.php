<?php

namespace Controller;

use Libs\Valid;
use Model\CommentModel;
use Model\PostModel;

/**
 * Class CommentController
 * @package Controller
 */
class CommentController extends MainController
{
    /**
     * @var PostModel
     */
    private PostModel $PostModel;
    /**
     * @var CommentModel
     */
    private CommentModel $CommentModel;

    /**
     * CommentController constructor.
     * @param PostModel $PostModel
     * @param CommentModel $CommentModel
     */
    public function __construct(PostModel $PostModel, CommentModel $CommentModel)
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

    /**
     * @param $post_id
     */
    public function add_post($post_id)
    {
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

                    header('Location: ' . ROOT_URL);
                    $_SESSION['CommentSuccessMsg'] = 'Hurray!! The comment has been added.';

                } else {

                    header('Location: ' . ROOT_URL . '/add-comment?id=' . $post_id);
                    $_SESSION['CommentErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
                }

                /**     end if add         */

            } else {

                header('Location: ' . ROOT_URL . '/add-comment?id=' . $post_id);
                $_SESSION['CommentErrorMsg'] = 'All fields are required  cannot exceed 250 characters and must be leettes and contains two single separated words .';
            }
        }//add comment if

    }

    public function add_get()
    {
        $this->getView('blog/add-comment');
    }

}