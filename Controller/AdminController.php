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
//todo: sprawdz czt ta zmioenna potrzbn id
    private $_iId;//update usage
    private AdminModel $AdminModel;//update usage
    public string $msg;


    public function __construct(AdminModel $AdminModel)
    {
        // Enable PHP Session
        if (empty($_SESSION))
            session_start();

        $this->AdminModel = $AdminModel;
    }

    use Valid;


    public function index()
    {
        //todo function below doesnt work  fix that
        // self::isRefreshedAdminPage();

        //  if (!empty($_SESSION['AdminErrorMsg'])) {
        //  unset($_SESSION['AdminErrorMsg']);
        //  }

        $this->oAdmins = $this->AdminModel->getAll();
        $this->getView('index_admin');
    }


    public function login_get()
    {
        if ($this->isLogged()) {
            header('Location: ' . MAIN_PAGE);
            exit();
        }

        $this->getView('login');
    }


    public function login_post()
    {
        // if (empty($_POST['submit'])) {
        //  if (!empty($_SESSION['AdminSuccMsg'])) {
        //  unset($_SESSION['AdminSuccMsg']);
        //   }
        //  }

        //  if (empty($_POST['submit'])) {
        //  if (!empty($_SESSION['AdminErrorMsg'])) {
        //    unset($_SESSION['AdminErrorMsg']);
        //  }
        //   }

        // if (!empty($_SESSION['AdminSuccMsg'])) {
        //    unset($_SESSION['AdminSuccMsg']);
        //  }


        if ($this->isLogged())
            header('Location: ' . MAIN_PAGE);

        if (isset($_POST['email'], $_POST['password'])) {

            $sHashPassword = $this->AdminModel->login($_POST['email']);

            if (password_verify($_POST['password'], $sHashPassword)) {

                //if (!empty($_SESSION['AdminErrorMsg'])) {
                //   unset($_SESSION['AdminErrorMsg']);
                //  }
                $_SESSION['is_logged'] = true;
                $_SESSION['userEmail'] = $_POST['email'];
                header('Location: ' . MAIN_PAGE);
                exit;

            } else {
                //spr czy to jest potrebne!!!
                //   if (!empty($_SESSION['AdminSuccMsg'])) {
                // unset($_SESSION['AdminSuccMsg']);
                //   }

                header('Location: ' . MAIN_ROOT_URL . '/login');
                $_SESSION['is_logged'] = false;
                $_SESSION['AdminErrorMsg'] = 'Incorrect Login!';
                error_log('Wrong logging try!!!');
            }
        }
    }

    public function logout()
    {
        if (!$this->isLogged())
            exit();

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

    /**REGISTER**/

    public function register_post()
    {
        //todo: dodoac klase walidator
        if (!$this->isLogged())
            exit;

        //to prevent unnecessary  display msg
        //  if (empty($_POST['register'])):if (!empty($_SESSION['AdminSuccMsg'])) {
        // unset($_SESSION['AdminSuccMsg']);
        //    }
        //  endif;

        //   if (empty($_POST['register'])):if (!empty($_SESSION['AdminErrorMsg'])) {
        //  unset($_SESSION['AdminErrorMsg']);
        //  }
        //  endif;


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
                    //check if given already email exists
                    foreach ($this->AdminModel->getAllEmails() as $email) {

                        if (strcmp($email->email, $_POST['email']) == 0) {
                            $flag = true;
                            break;
                        }
                    }

                    if ($flag == true) {

                        header('Location: ' . ROOT_URL . '/register');

                        //  if (!empty($_SESSION['AdminSuccMsg'])) {
                        // unset($_SESSION['AdminSuccMsg']);
                        //  }

                        $this->msg = 'Whoops! Email is already in use,please try  another one';
                        $_SESSION['AdminErrorMsg'] = $this->msg;
                        error_log($this->msg);

                    } else {

                        $aData = array(

                            'email' => self::test_input($_POST['email']),
                            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 14))
                        );

                        if ($this->AdminModel->register($aData)) {

                            header('Location: ' . ROOT_URL);

                            //  if (!empty($_SESSION['AdminErrorMsg'])) {
                            //   unset($_SESSION['AdminErrorMsg']);
                            //     }

                            $this->msg = 'Hurray!! The new user has been added.';
                            $_SESSION['AdminSuccMsg'] = $this->msg;

                        } else {

                            header('Location: ' . ROOT_URL . '/register');

                            //   if (!empty($_SESSION['AdminSuccMsg'])) {
                            // unset($_SESSION['AdminSuccMsg']);
                            //     }
                            $this->msg = 'Whoops! An error has occurred! Please try again later.';
                            $_SESSION['AdminErrorMsg'] = $this->msg;
                            error_log($this->msg);
                        }

                    }// else true flag
                } else {

                    header('Location: ' . ROOT_URL . '/register');

                    //    if (!empty($_SESSION['AdminSuccMsg'])) {
                    //     unset($_SESSION['AdminSuccMsg']);
                    //   }
                    $this->msg = 'Whoops! Confirm Password doesnt  match or contain less than 6 char. The password 
                    must contain at least  one leeter and one  digit.';

                    $_SESSION['AdminErrorMsg'] = $this->msg;
                    error_log($this->msg);
                }

            }//if isset post  ....

        }//!empty register button


    }


    public function register_get()
    {
        $this->getView('register_user');
    }


    public function getLogoutPage()
    {
        $this->getView('logout');
    }


    public function edit_post($admin_id)
    {
        if (!$this->isLogged()) exit;
        $this->oAdmin = $this->AdminModel->getById($admin_id);

        //to prevent unnecessary  display msg
        /*  if (empty($_POST['edit_submit'])):if (!empty($_SESSION['AdminSuccMsg'])) {
              unset($_SESSION['AdminSuccMsg']);
          }
          endif;

          if (empty($_POST['edit_submit'])):if (!empty($_SESSION['AdminErrorMsg'])) {
              unset($_SESSION['AdminErrorMsg']);
          }
          endif;*/

        if (!empty($_POST['edit_submit'])) {

            if (isset($_POST['email'], $_POST['password'])) {

                if (strcmp($_POST['password'], $_POST['confirm']) == 0
                    && strlen($_POST['password']) >= 6
                    && preg_match('/[A-Za-z]/', $_POST['password'])
                    && preg_match('/[0-9]/', $_POST['password'])) {


                    $aData = array('id' => self::test_input($admin_id),
                        'email' => self::test_input($_POST['email']),
                        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 14)));

                    //var_dump($this->oAdmin->email);
                    //gdy edytowany jest ten sam co edytowany wuloguj sie celem wprowdznie zmian

                    if ($_SESSION['userEmail'] === $this->oAdmin->email) {

                        if ($this->AdminModel->update($aData)) {

                            header('Location: ' . ROOT_URL . 'logout');

                            exit();
                        } else {

                            header('Location: ' . ROOT_URL . 'edit?id=' . $admin_id);

                            // if (!empty($_SESSION['AdminSuccMsg'])) {
                            //   unset($_SESSION['AdminSuccMsg']);
                            //   }
                            $this->msg = 'Ups smth wrong!!!!';
                            $_SESSION['AdminErrorMsg'] = $this->msg;
                        }
                    }

                    if ($this->AdminModel->update($aData)) {

                        header('Location: ' . ROOT_URL);

                        //    if (!empty($_SESSION['AdminErrorMsg'])) {
                        // unset($_SESSION['AdminErrorMsg']);
                        //    }
                        $this->msg = 'Hurray! The User (Admin) has been updated.';
                        $_SESSION['AdminSuccMsg'] = $this->msg;
                    }
                } else {

                    header('Location: ' . ROOT_URL . 'edit?id=' . $admin_id);

                    //   if (!empty($_SESSION['AdminSuccMsg'])) {
                    //   unset($_SESSION['AdminSuccMsg']);
                    //     }
                    $this->msg = 'Whoops! Confirm Password doesnt  match or contain less than 6 char. The password 
                    must contain at least  one leeter and one  digit.';
                    $_SESSION['AdminErrorMsg'] = $this->msg;
                }
            }
        }
    }


    public function edit_get($admin_id)
    {
        $this->oAdmin = $this->AdminModel->getById($admin_id);

        //var_dump($this->oAdmin->email);
        $this->getView('edit_user');
    }


    /*   public static function isRefreshedAdminPage()
       {
           $is_page_refreshed = (isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0');


           if ($is_page_refreshed) :

               //echo 'This Page Is refreshed.';

               if (!empty ($_SESSION['AdminSuccMsg'])) {
                   unset($_SESSION['AdminSuccMsg']);
               }

               endif;
       }*/


    //todo:dont delete admin when i same logged and leave at least one not deleted
    public function delete($admin_id)
    {
        if (!$this->isLogged()) exit;

        $this->oAdmin = $this->AdminModel->getById($admin_id);

        if (!empty($_POST['delete'])) {

            if ($this->AdminModel->countAdmins() > 1 && $this->oAdmin->email != $_SESSION['userEmail']) {

                if ($this->AdminModel->delete($admin_id)) {

                    header('Location: ' . ROOT_URL);

                    $_SESSION['AdminSuccMsg'] = 'User has been deleted properly';

                } else {
                    header('Location: ' . ROOT_URL);

                    $_SESSION['AdminErrorMsg'] = 'Whoops! Post cannot be deleted.';
                    // exit('Whoops! Post cannot be deleted.');

                }
            } else {
                header('Location: ' . ROOT_URL);

                $_SESSION['AdminErrorMsg'] = 'Whoops! You cant delete all users!!';
                exit('Whoops! You cant delete all users!! or yourself!!');

            }

        }
    }
}
