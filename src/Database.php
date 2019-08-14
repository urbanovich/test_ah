<?php

namespace TestAH;


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

    public function createTable()
    {
        $data = [];

        $data[] = 'CREATE TABLE IF NOT EXISTS posts (' .
            '`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ' .
            '`user_id` INT NOT NULL, ' .
            '`title` VARCHAR(256) NOT NULL, ' .
            '`content` TEXT(256), ' .
            'INDEX post (`id`, `user_id`) ' .
            ') ENGINE=MYISAM CHARACTER SET=utf8;';

        $dir = dirname(__DIR__) . '/code.html';
        $res = $this->mysqli->query('SELECT * FROM `posts`');
        if (file_exists($dir) && !$res->num_rows) {
            $data[] = 'INSERT INTO posts(user_id, title, content) VALUES (1, "title", "' . addslashes(file_get_contents($dir)). '");';
        }

        foreach ($data as $query) {
            if (!$this->mysqli->query($query)) {
                if ($this->mysqli->errno) {
                    echo $this->mysqli->error;
                }
            }
        }
    }

    public function execute($sql)
    {
        if (!$this->mysqli->query($sql)) {
            if ($this->mysqli->errno) {
                echo $this->mysqli->error;
            }

            return false;
        } else {
            return true;
        }
    }

    public function select($sql)
    {
        $res = $this->mysqli->query($sql);
        if ($this->mysqli->errno) {
            echo $this->mysqli->error;
            return false;
        }

        $result = [];
        $res->data_seek(0);
        while ($row = $res->fetch_assoc()) {
            $result[] = $row;
        }

        return $result;
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }

}