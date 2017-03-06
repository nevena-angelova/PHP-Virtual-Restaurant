<?php

include 'config/config.php';
include 'infrastructure/connection.php';
include 'infrastructure/utils.php';
include 'infrastructure/view_renderer.php';

//ajax request detection
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    include 'infrastructure/ajax-routing.php';
}else{
    include 'views/layout.php';
}








