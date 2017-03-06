<?php

class UserStatic
{
    public static function getUsers()
    {
        $db = DB::getInstance()->getConnection();

        $get_user_query = mysqli_query($db, 'SELECT id , user_name, image FROM users');
        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        if (mysqli_num_rows($get_user_query) == 0) {
            trigger_error('Invalid user.', E_USER_ERROR);
        }

        $users = array();
        while ($row = mysqli_fetch_assoc($get_user_query)) {
            $user = array();
            $user['id'] = $row['id'];
            $user['user_name'] = $row['user_name'];
            if (!empty($row['image'])) {
                $user['image'] = new Image('users', $row['image'], $row['user_name']);
            }
            $users[] = $user;
        }

        return $users;
    }

}