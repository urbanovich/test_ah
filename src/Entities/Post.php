<?php


namespace TestAH\Entities;

use TestAH\Database;

class Post
{

    public static function getPostsByIdUser($userId)
    {
        $db = Database::getInstance();
        $res = $db->select('SELECT * FROM posts WHERE `user_id` = ' . (int)$userId);

        return $res;
    }
}