<?php

class DB
{

    private static $instance = NULL;
    private $connection;
    //private $host = "localhost";
    private $host = "fdb16.zettahost.bg";
    //private $username = "nevena";
    private $username = "2312418_recipes";
    //private $password = "123456";
    private $password = "n@192837465";
    //private $database = "recipes";
    private $database = "2312418_recipes";

    private function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->connection) {
            trigger_error("Failed to conencto to MySQL: " . mysqli_error($this->connection), E_USER_ERROR);
        }

        mysqli_set_charset($this->connection, 'utf8');
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
