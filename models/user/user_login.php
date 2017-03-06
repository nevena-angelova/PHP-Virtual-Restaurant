<?php

class UserLogin extends User
{

    public function login($username, $pass)
    {
        $this->setUsername($username);
        $this->setPass($pass);

        if (count($this->validation_errors) === 0) {
            $db = DB::getInstance()->getConnection();
            $username_esc = mysqli_real_escape_string($db, $this->username);
            $get_user_query = mysqli_query($db, 'SELECT * FROM users WHERE user_name = "' . $username_esc . '" ');

            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            if (mysqli_num_rows($get_user_query) > 0) {
                $result = mysqli_fetch_assoc($get_user_query);
                $db_user_id = $result['id'];
                $db_pass = $result['password'];
                $db_username = $result['user_name'];
                $pass_hashed = Utils::hashPass($this->pass, $username_esc);
                if ($db_pass === $pass_hashed) {
                    $_SESSION['is_logged'] = true;
                    $_SESSION['user_id'] = $db_user_id;
                    $_SESSION['username'] = $db_username;
                    return true;
                }
            }

            $this->validation_errors['user_login'] = "Грешено потребителско име или парола.";

        }

        return false;
    }

    public function logout()
    {
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }

}