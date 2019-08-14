<?php

require_once "src/autoload.php";

use TestAH\Database;
use TestAH\Entities\Post;
use TestAH\Helpers\ParserHtml;

$db = Database::getInstance();
$db->createTable();

$posts = Post::getPostsByIdUser(1);

if (!empty($posts)) {
    $result = ParserHtml::parse($posts[0]['content']);
}
