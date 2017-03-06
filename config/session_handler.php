<?php

class LazySessionHandler{

    public static function lazySessionStart() {
        if (!isset($_SESSION) || !is_array($_SESSION)) {
            session_name('securesession');
            session_set_cookie_params(3600, '/', '127.0.0.1', false, true);
            session_start();
        }
        //print_r($_SESSION);
    }


}