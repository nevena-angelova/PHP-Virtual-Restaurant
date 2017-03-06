<?php
include 'models/image.php';
include 'models/user/user.php';
include 'models/user/user_profile.php';
include 'models/user/user_login.php';
include 'models/user/user_static.php';

class UserController
{

    public function login(){
        $user = new UserLogin();
        if ($_POST) {
            $result = $user->login($_POST['username'], $_POST['pass']);
            if ($result == true) {
                header('Location: ?c=user&a=profile&id=' . $_SESSION['user_id']);
            }
        }

        ViewRenderer::render('views/pages/user/login.php', $user);
    }

    public function register(){
        $user = new UserProfile();
        $user->setAction('register');
        if ($_POST) {
            $user_id = $user->insertUser();
            if ($user_id != NULL) {
                header('Location: ?c=user&a=profile&id=' . $user_id);
            }
        }

        ViewRenderer::render('views/pages/user/form.php', $user);
    }

    public function edit(){
        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true) {
            $user = new UserProfile();
            $user->setAction('edit');

            if (isset($_GET['id'])) {
                $user->getUserData();
            }

            if ($_POST) {
                $user_id = $user->editUser();
                if ($user_id != NULL) {
                    header('Location: ?c=user&a=profile&id=' . $user_id);
                }
            }

            ViewRenderer::render('views/pages/user/form.php', $user);
        } else {
            trigger_error('Not authorized!', E_USER_ERROR);
        }
    }

    public function profile(){
        if (isset($_GET['id'])) {
            $user = new UserProfile();
            $user->getUserData();
            ViewRenderer::render('views/pages/user/profile.php', $user);
        } else {
            trigger_error('Wrong request!', E_USER_ERROR);
        }
    }

    public function logout(){
        $user = new UserLogin();
        $user->logout();
        header('Location: ?controller=home&action=index');
    }

    public function all(){

        $users = UserStatic::getUsers();
        ViewRenderer::render('views/pages/user/list.php', $users);

    }

}

