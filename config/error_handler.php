<?php

class ErrorHandler
{
    private static $instance = null;

    private function __construct() {
        set_error_handler(array($this, "debugErrorHandler"));
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function debugErrorHandler($errno, $errstr, $errfile, $errline){
            if (!(error_reporting() & $errno)) {
                // This error code is not included in error_reporting, so let it fall
                // through to the standard PHP error handler
                return false;
            }

            switch ($errno) {

                case E_USER_ERROR:
                    echo "<b>E_USER_ERROR</b> [$errno] $errstr<br />\n";
                    echo "  Fatal error on line $errline in file $errfile";
                    echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                    echo "Aborting...<br />\n";
                    exit(1);
                    break;

                case E_USER_WARNING:
                    echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
                    break;

                case E_USER_NOTICE:
                    echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
                    break;

                default:
                    echo "Unknown error type: [$errno] $errstr<br />\n";
                    echo "<b>Unknown error type</b> [$errno] $errstr<br />\n";
                    echo " Unknown error type on line $errline in file $errfile";
                    echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                    echo "Aborting...<br />\n";
                    exit(1);
                    break;
            }

            /* Don't execute PHP internal error handler */
            return true;

    }
}