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

    $templateFile = dirname(__FILE__) . '/template.html';

    if (file_exists($templateFile)) {
        $template = file_get_contents($templateFile);
        $template = str_replace('{{LEFT}}', $result['left'], $template);
        $template = str_replace('{{RIGHT}}', $result['right'], $template);
    } else {
        throw new Exception('template.html file does not found.');
    }

    echo $template;
}
