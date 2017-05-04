<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Виртуален ресторант</title>

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- JAVASCRIPT JS FILES -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <?php
    if (isset($_GET['c']) && (
            ($_GET['c'] == 'user' && ($_GET['a'] == 'login') || $_GET['a'] == 'register' || $_GET['a'] == 'edit')
            || ($_GET['c'] == 'recipe' && ($_GET['a'] == 'add') || $_GET['a'] == 'edit')
        )
    ) {
        echo '<script src="js/jquery.validate.min.js"></script>
              <script src="js/messages_bg.js"></script>
              <script src="js/pages/forms.js"></script>';
    }
    ?>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nivo-lightbox.css">
    <link rel="stylesheet" href="css/nivo_themes/default/default.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>

    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>
<body>

<!-- preloader section -->
<section class="preloader">
    <div class="sk-spinner sk-spinner-pulse"></div>
</section>

<!-- navigation section -->
<section class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>
            <a href="?c=home&a=index" class="navbar-brand">
                <img alt="лого" src="images/logo.png">
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                $is_logged = isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true;
                if ($is_logged) {
                    echo '<li class="username-nav-item"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <span class="glyphicon glyphicon-user"></span>' . $_SESSION['username'] . '</a>
                                <ul class="dropdown-menu">
                                    <li><a href="?c=user&a=profile&id=' . $_SESSION['user_id'] . '">
                                    Профил</a>
                                    </li>
                                     <li><a href="?c=recipe&a=add">
                                      Добави рецепта</a>
                                    </li>
                                </ul>
                        </li>';
                }
                ?>
                <li>
                    <a href="?c=home&a=index" class="smoothScroll">НАЧАЛО</a>
                </li>
                <li><a href="?c=recipe&a=all">РЕЦЕПТИ</a></li>
                <li><a href="?c=user&a=all">ПОТРЕБИТЕЛИ</a></li>
                <?php
                if ($is_logged) {
                    echo '<li class="logout-nav-item"><a href="?c=user&a=logout"><span class="glyphicon glyphicon-log-out"></span></a></li>';
                }
                ?>

            </ul>
        </div>
    </div>
</section>

<?php
include 'infrastructure/routing.php';
?>

<!-- footer section -->
<footer class="parallax-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.6s">
                <h2 class="heading">Информация за контакт</h2>

                <div class="ph">
                    <p><i class="fa fa-phone"></i> Телефон</p>
                    <h4>090-080-0760</h4>
                </div>
                <div class="address">
                    <p><i class="fa fa-map-marker"></i> Адрес</p>
                    <h4>гр. София, жк. Младост 3</h4>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.6s">
                <h2 class="heading">Работно време</h2>

                <p>Неделя <span>10:30 - 18:00</span></p>

                <p>Понеделник-Петък <span>9:00 - 22:00 </span></p>

                <p>Събота <span>10:30 - 21:00</span></p>
            </div>
            <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.6s">
                <h2 class="heading">Следвайте ни</h2>
                <ul class="social-icon">
                    <li><a href="#" class="fa fa-facebook wow bounceIn" data-wow-delay="0.3s"></a></li>
                    <li><a href="#" class="fa fa-twitter wow bounceIn" data-wow-delay="0.6s"></a></li>
                    <li><a href="#" class="fa fa-behance wow bounceIn" data-wow-delay="0.9s"></a></li>
                    <li><a href="#" class="fa fa-dribbble wow bounceIn" data-wow-delay="0.9s"></a></li>
                    <li><a href="#" class="fa fa-github wow bounceIn" data-wow-delay="0.9s"></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<!-- copyright section -->
<section id="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3>Виртуален ресторант</h3>

                <p>© Виртуален ресторант

                    | Design: <a rel="nofollow" href="" target="_parent">nevena</a></p>
            </div>
        </div>
    </div>
</section>

<!-- JAVASCRIPT JS FILES -->
<script src="js/jquery.parallax.js"></script>
<script src="js/smoothscroll.js"></script>
<script src="js/nivo-lightbox.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/custom.js"></script>

<?php

if (isset($_GET['c']) && $_GET['c'] == 'user' && $_GET['a'] == 'profile') {
    echo '<script src="js/pages/profile.js"></script>';
}

if (isset($_GET['c']) && $_GET['c'] == 'home' && $_GET['a'] == 'index') {
    echo '<script src="js/pages/home.js"></script>';
}

?>

</body>
</html>