<?php

namespace Controller;

use Libs\MainInterface;

/**
 * Class MainController
 * @package Controller
 */
abstract class MainController implements MainInterface
{
    /**
     * @var array
     */
    protected array $oAdmins;

    /**
     * @param $sViewName
     */
    public function getView($sViewName)
    {
        $this->_get($sViewName);
    }

    /**
     * @param $sFileName
     */
    public function _get($sFileName)
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
    public function isLogged()
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

            if (!empty($_SESSION['AdminErrorMsg'])) {
                unset($_SESSION['AdminErrorMsg']);
            }
            if (!empty($_SESSION['AdminSuccMsg'])) {
                unset($_SESSION['AdminSuccMsg']);
            }
            return true;
        } else {
            return false;
        }


    }
}
