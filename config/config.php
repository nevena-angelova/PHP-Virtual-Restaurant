<?php

date_default_timezone_set("Europe/Helsinki");

include 'config/error_handler.php';
include 'config/session_handler.php';

ErrorHandler::getInstance();

LazySessionHandler::lazySessionStart();
