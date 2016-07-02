<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 27.06.2016
 * Time: 23:00
 */
include_once("./config.php");

class DataBase
{
    private $connect;
    private $dbName;
    private $host;
    private $user;
    private $pass;

    private static $instance = null;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DataBase(HOST, USER, PASS, DB_NAME);
        }
        return self::$instance;
    }

    private function __construct($host, $user, $pass, $dbName)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;

        if (!($this->connect = mysql_connect($this->host, $this->user, $this->pass))) {
            die();
        }
        if (!(mysql_select_db($this->dbName))) {
            die();
        }
    }

    public function getResult($sqlQuery)
    {
        return mysql_fetch_assoc(mysql_query($sqlQuery));
    }

    public function executeQuery($sqlQuery)
    {
        return mysql_query($sqlQuery);
    }

    public function __destruct()
    {
        mysql_close($this->connect);
    }

}