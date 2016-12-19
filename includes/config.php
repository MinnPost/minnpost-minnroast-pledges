<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$dbname = getenv('DATABASE_NAME');
$host = getenv('DATABASE_HOST');
$dbuser = getenv('DATABASE_USER');
$dbpass = getenv('DATABASE_PASS');

$db = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass); 

$table = getenv('DATABASE_TABLE');
$url = getenv('ROOT_URL');
$title = getenv('TITLE');
$main_label = getenv('MAIN_LABEL');
$thanks_label = getenv('THANKS_LABEL');