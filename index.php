<?php

require_once "src/autoload.php";

$db = new TestAH\Database();
$db->createTable();

echo 'Hello World!!!';