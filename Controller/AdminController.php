<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

namespace Controller;

use Libs\Valid;
use Model\AdminModel;

class AdminController extends MainController
{

    private $_iId;//update usage

    /**
     * @var
     */
    protected $oEmail;//show current chosen from url id user email

    public function __construct()
    {
        // Enable PHP Session
        if (empty($_SESSION))
            session_start();

        /** Get the Post ID in the constructor in order to avoid the duplication of the same code **/
       // $this->_iId = (int)(!empty($_GET['id']) ? $_GET['id'] : 0);
        $this->oEmail = $this->getAModelObject()->getEmailById($this->_iId);

    }

    use Valid;

    public function createAModelObject()
    {
        return new AdminModel();
    }

    public function getAModelObject()
    {
        return $this->createAModelObject();
    }


    public function index()
    {
        //todo function below doesnt work  fix that
        // self::isRefreshedAdminPage();
        if (!empty($_SESSION['AdminErrorMsg'])) {
            unset($_SESSION['AdminErrorMsg']);
        }

        $this->oAdmins = $this->getAModelObject()->getAll();

        $this->getView('index_admin');
    }


    public function login()
    {
        if (empty($_POST['submit'])) {
            if (!empty($_SESSION['AdminSuccMsg'])) {
                unset($_SESSION['AdminSuccMsg']);
            }
        }

        if (empty($_POST['submit'])) {
            if (!empty($_SESSION['AdminErrorMsg'])) {
                unset($_SESSION['AdminErrorMsg']);
            }
        }

        if (!empty($_SESSION['AdminSuccMsg'])) {
            unset($_SESSION['AdminSuccMsg']);
        }
        if ($this->isLogged())
            header('Location: ' . ROOT_URL . '?p=blog&a=all');

        if (isset($_POST['email'], $_POST['password'])) {

            $sHashPassword = $this->getAModelObject()->login($_POST['email']);

            if (password_verify($_POST['password'], $sHashPassword)) {

                $_SESSION['is_logged'] = true;
                $_SESSION['userEmail'] = $_POST['email'];
                header('Location: ' . ROOT_URL . '?p=blog&a=all');

                exit;
            } else {
                //spr czy to jest potrebne!!!
                if (!empty($_SESSION['AdminSuccMsg'])) {
                    unset($_SESSION['AdminSuccMsg']);
                }
                $_SESSION['AdminErrorMsg'] = 'Incorrect Login!';
            }
        }

        $this->getView('login');
    }

    public function logout()
    {
        if (!$this->isLogged())
            exit;

        // If there is a session, destroy it to disconnect the admin
        if (!empty($_SESSION)) {
            $_SESSION = array();
            session_unset();
            session_destroy();
        }

        // Redirect to login page
        header('Location: ' . ROOT_URL . '/login');
        exit;
    }

    public function register()
    {
        //todo: dodoac klase walidator
        if (!$this->isLogged())
            exit;

        //to prevent unnecessary  display msg
        if (empty($_POST['register'])):if (!empty($_SESSION['AdminSuccMsg'])) {
            unset($_SESSION['AdminSuccMsg']);
        }
        endif;

        if (empty($_POST['register'])):if (!empty($_SESSION['AdminErrorMsg'])) {
            unset($_SESSION['AdminErrorMsg']);
        }
        endif;


        if (!empty($_POST['register'])) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            } else {
                exit;
            }

            if (isset($_POST['email'], $_POST['password'], $_POST['confirm'])) {

                /**
                 * if password confirmed and contain min 6
                 * char and contains  at least one letter and one number
                 * min check if email is already in use
                 */

                if (strcmp($_POST['password'], $_POST['confirm']) == 0
                    && strlen($_POST['password']) >= 6 &&
                    preg_match('/[A-Za-z]/', $_POST['password'])
                    && preg_match('/[0-9]/', $_POST['password'])
                    && !empty($_POST['email'])) {

                    $flag = false;
                    foreach ($this->getAModelObject()->getAllEmails() as $email) {

                        if (strcmp($email->email, $_POST['email']) == 0) {
                            $flag = true;
                            break;
                        }
                    }

                    if ($flag == true) {
                        if (!empty($_SESSION['AdminSuccMsg'])) {
                            unset($_SESSION['AdminSuccMsg']);
                        }
                        $_SESSION['AdminErrorMsg'] = 'Whoops! Email is already in use  ,please try  another one';

                    } else {

                        $aData = array(

                            'email' => self::test_input($_POST['email']),
                            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 14))
                        );

                        if ($this->getAModelObject()->register($aData)) {

                            if (!empty($_SESSION['AdminErrorMsg'])) {
                                unset($_SESSION['AdminErrorMsg']);
                            }

                            header('Location: ' . ROOT_URL . '?p=admin&a=index');
                            $_SESSION['AdminSuccMsg'] = 'Hurray!! The new user has been added.';

                        } else {
                            if (!empty($_SESSION['AdminSuccMsg'])) {
                                unset($_SESSION['AdminSuccMsg']);
                            }

                            $_SESSION['AdminErrorMsg'] = 'Whoops! An error has occurred! Please try again later.';
                        }

                    }// else true flag
                } else {
                    if (!empty($_SESSION['AdminSuccMsg'])) {
                        unset($_SESSION['AdminSuccMsg']);
                    }

                    $_SESSION['AdminErrorMsg'] = 'Whoops! Confirm Password doesnt  match or contain less than 6 char. The password 
                    must contain at least  one leeter and one  digit.';
                }

            }//if isset post  ....

        }//!empty register button

        $this->getView('register_user');
    }

    public function getLogoutPage()
    {
      //  $this->oEmail = $this->getAModelObject()->getEmailById($this->_iId);
        $this->getView('logout');
    }

    public function edit()
    {
        if (!$this->isLogged()) exit;

        //to prevent unnecessary  display msg
        if (empty($_POST['edit_submit'])):if (!empty($_SESSION['AdminSuccMsg'])) {
            unset($_SESSION['AdminSuccMsg']);
        }
        endif;

        if (empty($_POST['edit_submit'])):if (!empty($_SESSION['AdminErrorMsg'])) {
            unset($_SESSION['AdminErrorMsg']);
        }
        endif;

        if (!empty($_POST['edit_submit'])) {

            if (isset($_POST['email'], $_POST['password'])) {

                if (strcmp($_POST['password'], $_POST['confirm']) == 0
                    && strlen($_POST['password']) >= 6
                    && preg_match('/[A-Za-z]/', $_POST['password'])
                    && preg_match('/[0-9]/', $_POST['password'])) {


                    $aData = array('id' => self::test_input($this->_iId),
                        'email' => self::test_input($_POST['email']),
                        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 14)));

                    //if redirect if updated yourself(logged user)todo: chek if you can doyhis in constructor

                  //  $this->oEmail = $this->getAModelObject()->getEmailById($this->_iId);

                    if ($_SESSION['userEmail'] === $this->oEmail->email) {

                        if (($this->getAModelObject()->update($aData))) {
                            header('Location: ' . ROOT_URL . '?p=admin&a=getLogoutPage');
                            exit();
                        } else {
                            header('Location: ' . ROOT_URL . '?p=admin&a=index');
                            if (!empty($_SESSION['AdminErrorMsg'])) {
                                unset($_SESSION['AdminErrorMsg']);
                            }
                        }


                    }

                    if (($this->getAModelObject()->update($aData))) {

                        header('Location: ' . ROOT_URL . '?p=admin&a=index');
                        if (!empty($_SESSION['AdminErrorMsg'])) {
                            unset($_SESSION['AdminErrorMsg']);
                        }

                        $_SESSION['AdminSuccMsg'] = 'Hurray! The User (Admin) has been updated.';
                    }
                } else {
                    if (!empty($_SESSION['AdminSuccMsg'])) {
                        unset($_SESSION['AdminSuccMsg']);
                    }

                    $_SESSION['AdminErrorMsg'] = 'Whoops! Confirm Password doesnt  match or contain less than 6 char. The password 
                    must contain at least  one leeter and one  digit.';
                }
            }
        }

        /* Get the data of the post */

        $this->oAdmin = $this->getAModelObject()->getById($this->_iId);

        $this->getView('edit_user');
    }


    public static function isRefreshedAdminPage()
    {
        $is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');


        if ($is_page_refreshed) :

            //echo 'This Page Is refreshed.';

            if (!empty ($_SESSION['AdminSuccMsg'])) {
                unset($_SESSION['AdminSuccMsg']);
            }


        endif;
    }


    //todo:dont delete admin when i same logged and leave at least one not deleted
    public function delete()
    {
        if (!$this->isLogged()) exit;


        if (!empty($_POST['delete'])) {


            if ($this->getAModelObject()->countAdmins() > 1 && $this->oEmail->email != $_SESSION['userEmail']) {

                if ($this->getAModelObject()->delete($this->_iId)) {
                    header('Location: ' . ROOT_URL . '?p=admin&a=index');
                    $_SESSION['AdminSuccMsg'] = 'User has been deleted properly';

                } else {
                      header('Location: ' . ROOT_URL . '?p=admin&a=index');
                    $_SESSION['AdminErrorMsg'] = 'Whoops! Post cannot be deleted.';
                    exit('Whoops! Post cannot be deleted.');

                }
            } else {
                  header('Location: ' . ROOT_URL . '?p=admin&a=index');
                $_SESSION['AdminErrorMsg'] = 'Whoops! You cant delete all users!!';
                exit('Whoops! You cant delete all users!! or yourself!!');

            }

        }
    }
}
