<?php

if (isset($_GET['c']) && isset($_GET['a'])) {
    $controller = $_GET['c'];
    $action = $_GET['a'];
} else {
    $controller = 'home';
    $action = 'index';
}

// just a list of the controllers we have and their actions
// we consider those "allowed" values
$controllers = array(
    'home' => ['index', 'error'],
    'user' => ['login', 'register', 'edit', 'profile', 'logout', 'all'],
    'recipe' => ['add', 'view', 'all', 'edit'],
);

// check that the requested controller and action are both allowed
// if someone tries to access something else he will be redirected to the error action of the pages controller
if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('home', 'error');
    }
} else {
    call('home', 'error');
}

function call($controller, $action)
{
    // includes the file that matches the controller name
    include('controllers/' . $controller . '_controller.php');

    // create a new instance of the needed controller
    switch ($controller) {
        case 'home':
            $controller = new HomeController();
            break;
        case 'user':
            $controller = new UserController();
            break;
        case 'recipe':
            $controller = new RecipeController();
            break;

    }

    // call the action
    $controller->{$action}();
}
