<?php

namespace Controller;
/**
 *
 * Class MainController
 * @package TestProject\Libs
 */
class MainController
{

    /**
     * @var array
     */
    protected $oAdmins;
    /**
     * @var string
     */
    private $sSuccMsg;
    /**
     * @var string
     */
    private $sErrMsg;


    public function getView($sViewName)
    {
        $this->_get($sViewName);
    }


    /**
     * This method is useful in order to avoid the duplication of code (create almost the same method for "getView" and "getModel"
     *
     * @param $sFileName
     * @param $sType
     *
     * jest to uzupenienie getview wykorzytywanego w kontrolerze - ustala sciezki dostepowe do widokow
     *
     */
    private function _get($sFileName)
    {
        $sFullPath = ROOT_PATH . '/View/' . $sFileName . '.php';


        if (is_file($sFullPath))
            require $sFullPath;
        else {
            echo ROOT_PATH . '<br>';

            echo $sFullPath . '<br>';
            echo $sFileName;

            exit('The "' . $sFullPath . '" file doesn\'t exist');
        }

    }

    /**
     * Set variables for the template views.
     * umozliwia zwoot dowodoku pomimo ze oPosts jest prywatna
     *
     * @return void
     */
    public function __set($sKey, $mVal)
    {
        $this->$sKey = $mVal;
    }

    /**
     * @return bool
     */
    protected function isLogged()
    {
        return !empty($_SESSION['is_logged']);
    }

    /**
     * @return bool
     *
     * to help manage display  notofocations on main posts page
     */
    public static function isPageRefreshed()
    {
        $is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');

        if ($is_page_refreshed) {

            if (!empty ($_SESSION['PostSuccessMsg'])) {
                unset($_SESSION['PostSuccessMsg']);
            }
            if (!empty($_SESSION['PostErrorMsg'])) {
                unset($_SESSION['PostErrorMsg']);
            }

            if (!empty($_SESSION['CommentSuccessMsg'])) {
                unset($_SESSION['CommentSuccessMsg']);
            }

            if (!empty($_SESSION['CommentErrorMsg'])) {
                unset($_SESSION['CommentErrorMsg']);
            }
            return true;
        } else {
            return false;
        }


    }


    /* public static function manageNotif()
     {
         if (!empty($_SESSION['CommentSuccessMsg'])) {
             unset($_SESSION['CommentSuccessMsg']);
         }

         if (empty($_POST['add_submit'])): if (!empty($_SESSION['PostSuccessMsg'])) {
             unset($_SESSION['PostSuccessMsg']);
         }
         endif;

         if (empty($_POST['add_submit'])): if (!empty($_SESSION['PostErrorMsg'])) {
             unset($_SESSION['PostErrorMsg']);
         }
         endif;
     }*/


}
