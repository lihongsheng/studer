<?php
namespace Application\Controller\User;

use Lib\Controller;
use Lib\Tools;
use Model\UserModel;

class User extends Controller
{

    /**
     * login view
     *
     */
    public function login()
    {
       $token = Tools::createId();
       $_SESSION[$token] = 0;
        $this->assign('title', 'login');
       $this->assign('token', $token);
       unset($_SESSION['user']);
       $this->display();
    }

    /**
     * login
     * @throws \Exception
     */
    public function doLogin()
    {
        $token = $_POST['token'] ?? '';
        //xsrf
        $loginUrl = "/user/user/login";
        $home = "/user/user/home";

        if (empty($token) || !isset($_SESSION[$token])) {
            //echo $token."<br/>";
            $this->redirect($loginUrl);
        }
        unset($_SESSION[$token]);
        $userModel = new UserModel();
        $userInfo = $userModel->find($_POST['username'],$_POST['password']);
        if ($userInfo) {
            $this->redirect($loginUrl);
        }
        $_SESSION['user'] = $userInfo;
        //var_dump($_SESSION);
        $this->redirect($home);

    }



    public function register()
    {
        $token = Tools::createId();
        $_SESSION[$token] = 0;
        $this->assign('title', 'register');
        $this->assign('token', $token);
        $this->display();
    }


    public function doReister()
    {
        $token = $_POST['token'] ?? '';
        //xsrf
        $registerUrl = "/user/user/register";
        $home = "/user/user/home";
        if (empty($token) || !isset($_SESSION[$token])) {
            $this->redirect($registerUrl);
        }
        unset($_SESSION[$token]);
        $userModel = new UserModel();
        $fieldVal = [
            'user_name' => $_POST['Name'],
            'username' => $_POST['UserName'],
            'age' => $_POST['Age'],
            'address' => $_POST['Address'],
            'password' => $_POST['Password'],
            'email' => $_POST['Email'],
        ];

        if(!$userModel->add($fieldVal)) {
            $this->redirect($registerUrl);
        }
        $_SESSION['user'] = $fieldVal;
        $this->redirect($home);
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        $this->redirect('/');

    }

    public function home()
    {
        $loginUrl = "/user/user/login";
        if (empty($_SESSION['user'])) {
            $this->redirect($loginUrl);
        }
        $this->assign('title','home');
        $this->display();
    }


}