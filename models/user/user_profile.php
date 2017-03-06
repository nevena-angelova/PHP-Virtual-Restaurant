<?php

class UserProfile extends User
{
    private $first_name;
    private $last_name;
    private $email;
    private $about;
    private $image;
    protected $register_date;
    protected $action;

    public function __construct()
    {
        $this->validation_rules['first_name_len'] = array('min' => 3, 'max' => 20, 'msg' => 'Невалидно име (от 3 до 20 символа).');
        $this->validation_rules['last_name_len'] = array('min' => 3, 'max' => 20, 'msg' => 'Невалидна фамиля (от 3 до 20 символа).');
        $this->validation_rules['email_len'] = array('max' => 50, 'msg' => 'Невалиден email.');
        $this->validation_rules['about_len'] = array('min' => 3, 'max' => 500, 'msg' => 'Невалидно описание (от 3 до 500 символа).');
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $first_name_trimmed = trim($first_name);
        if ($first_name_trimmed == NULL || mb_strlen($first_name_trimmed) >= $this->validation_rules['first_name_len']['min'] && mb_strlen($first_name_trimmed) <= $this->validation_rules['first_name_len']['max']) {
            $this->first_name = $first_name_trimmed;
        } else {
            $this->validation_errors['first_name'] = $this->validation_rules['first_name_len']['msg'];
        }
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $last_name_trimmed = trim($last_name);
        if ($last_name_trimmed == NULL || mb_strlen($last_name_trimmed) >= $this->validation_rules['last_name_len']['min'] && mb_strlen($last_name_trimmed) <= $this->validation_rules['last_name_len']['max']) {
            $this->last_name = $last_name_trimmed;
        } else {
            $this->validation_errors['last_name'] = $this->validation_rules['last_name_len']['msg'];
        }
    }

    function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $email_trimmed = trim($email);
        if ($email_trimmed != NULL && filter_var($email_trimmed, FILTER_VALIDATE_EMAIL)
            && mb_strlen($email_trimmed) <= $this->validation_rules['email_len']['max']
        ) {
            $this->email = $email_trimmed;
        } else {
            $this->validation_errors['email'] = $this->validation_rules['email_len']['msg'];
        }
    }

    function getAbout()
    {
        return $this->about;
    }

    public function setAbout($about)
    {
        $about_trimmed = trim($about);
        if ($about_trimmed == NULL || (mb_strlen($about_trimmed) >= $this->validation_rules['about_len']['min']
                && mb_strlen($about_trimmed) <= $this->validation_rules['about_len']['max'])
        ) {
            $this->about = $about_trimmed;
        } else {
            $this->validation_errors['about'] = $this->validation_rules['about_len']['msg'];
        }
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getRegisterDate()
    {
        return $this->register_date;
    }

    public function setRegisterDate()
    {
        $format = 'Y-m-d H:i:s';
        $ts = time();
        $this->register_date = date($format, $ts);
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getUserData()
    {
        $db = DB::getInstance()->getConnection();

        $id_esc = mysqli_real_escape_string($db, $_GET['id']);
        $get_user_query = mysqli_query($db, 'SELECT * FROM users WHERE id = "' . $id_esc . '" ');
        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        if (mysqli_num_rows($get_user_query) == 0) {
            trigger_error('Invalid user.', E_USER_ERROR);
        }

        $result = mysqli_fetch_assoc($get_user_query);
        $this->id = $result['id'];
        $this->username = $result['user_name'];
        if (!empty($result['first_name'])) {
            $this->first_name = $result['first_name'];
        }
        if (!empty($result['last_name'])) {
            $this->last_name = $result['last_name'];
        }
        $this->email = $result['email'];
        $this->about = $result['about'];
        if (!empty($result['image'])) {
            $this->image = new Image('users', $result['image'], $result['user_name']);
        }

        $this->register_date = $result['register_date'];

    }

    public function insertUser()
    {
        $this->setUsername($_POST['username']);
        $this->setPass($_POST['pass']);
        $this->setFirstName($_POST['first_name']);
        $this->setLastName($_POST['last_name']);
        $this->setEmail($_POST['email']);
        $this->setAbout($_POST['about']);
        $this->setRegisterDate();

        $pass_repeat_trimmed = trim($_POST['pass_repeat']);
        if ($this->pass != $pass_repeat_trimmed) {
            $this->validation_errors['user_exists'] = "Паролите не съвпадат.";
        }

        $db = DB::getInstance()->getConnection();

        $username_esc = mysqli_real_escape_string($db, $this->username);
        $user_exists_query = mysqli_query($db, 'SELECT * FROM users WHERE user_name = "' . $username_esc . '" ');
        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        if (mysqli_num_rows($user_exists_query) > 0) {
            $this->validation_errors['user_exists'] = "Съществува потребител със същото име.";
        }

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image = new Image('users', $_FILES['image']['name'], $username_esc);
            $image->uploadToServer();
            if (count($image->getValidationErrors() === 0)) {
                $this->image = $image;
            } else {
                $this->validation_errors = array_merge($this->validation_errors, $image->getValidationErrors());
            }
        }

        if (count($this->validation_errors) === 0) {
            $pass_esc = mysqli_real_escape_string($db, $this->pass);
            $pass_hashed = Utils::hashPass($pass_esc, $username_esc);
            $first_name_esc = mysqli_real_escape_string($db, $this->first_name);
            $last_name_esc = mysqli_real_escape_string($db, $this->last_name);
            $email_esc = mysqli_real_escape_string($db, $this->email);
            $about_esc = mysqli_real_escape_string($db, $this->about);
            $img_esc = null;
            if ($this->image != null) {
                $file_name = $this->image->getFileName();
                $img_esc = mysqli_real_escape_string($db, $file_name);
            }

            $sql = 'INSERT INTO recipes.users(user_name, password, first_name, last_name, email, image, about, register_date )'
                . ' VALUES ("' . $username_esc . '","' . $pass_hashed . '","' . $first_name_esc . '","' . $last_name_esc . '","' . $email_esc . '","' . $img_esc . '","' . $about_esc . '","' . $this->register_date . '" )';

            mysqli_query($db, $sql);
            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            $db_user_id = mysqli_insert_id($db);
            $_SESSION['is_logged'] = true;
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['username'] = $username_esc;

            return $db_user_id;
        }
    }

    public function editUser()
    {
        $db = DB::getInstance()->getConnection();

        $id_esc = mysqli_real_escape_string($db, $_GET['id']);
        $get_user_sql = 'SELECT id, image FROM `users` WHERE id = ' . $id_esc;
        $get_user_query = mysqli_query($db, $get_user_sql);

        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        if (mysqli_num_rows($get_user_query) == 0) {
            trigger_error('No user found.', E_USER_ERROR);
        }

        $result = mysqli_fetch_assoc($get_user_query);

        if ($result['id'] != $_SESSION['user_id']) {
            trigger_error('The current user does not match the profile owner.', E_USER_ERROR);
        }

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image = new Image('users', $_FILES['image']['name'], $_SESSION['username']);
            $image->uploadToServer();
            if (count($image->getValidationErrors()) === 0) {
                $this->image = $image;
                if ($result['image'] != null && $this->image->getFileName() != $result['image']) {
                    $old_img = $image->getPath() . $result['image'];
                    unlink($old_img);
                }
            } else {
                $this->validation_errors = array_merge($this->validation_errors, $image->getValidationErrors());
            }
        }

        $this->setFirstName($_POST['first_name']);
        $this->setLastName($_POST['last_name']);
        $this->setEmail($_POST['email']);
        $this->setAbout($_POST['about']);

        if (count($this->validation_errors) === 0) {
            $first_name_esc = mysqli_real_escape_string($db, $this->first_name);
            $last_name_esc = mysqli_real_escape_string($db, $this->last_name);
            $email_esc = mysqli_real_escape_string($db, $this->email);
            $about_esc = mysqli_real_escape_string($db, $this->about);
            $img_esc = null;
            if ($this->image != null) {
                $file_name = $this->image->getFileName();
                $img_esc = mysqli_real_escape_string($db, $file_name);
            }

            $sql = 'UPDATE recipes.users SET first_name = "'.$first_name_esc.'",
             last_name ="'.$last_name_esc.'",
             email = "'.$email_esc.'", image = "'.$img_esc.'", about = "'.$about_esc.'"'.
             ' WHERE `users`.`id` = ' . $id_esc;

            mysqli_query($db, $sql);
            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            return $_SESSION['user_id'];
        }

    }
}
