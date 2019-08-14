<?php

namespace TestAH;

use mysql_xdevapi\Exception;

class Database
{
    private $mysqli;

    private static $instance;

    public function __construct()
    {
        if (!extension_loaded('mysqli')) {
            throw new \Exception('Your server does not have "mysqli"');
        }

        $settings = Settings::getInstance();
        $this->mysqli = new \mysqli($settings->getDbHost(), $settings->getDbUser(), $settings->getDbPass(), $settings->getDbName());
        if ($this->mysqli->connect_errno) {
            echo $this->mysqli->connect_error;
        }
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


}