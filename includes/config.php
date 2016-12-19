<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
if (file_exists('.env')) {
	$dotenv->load();
}

$dbtype = getenv('DATABASE_TYPE');
$dbname = getenv('DATABASE_NAME');
$host = getenv('DATABASE_HOST');
$dbuser = getenv('DATABASE_USER');
$dbpass = getenv('DATABASE_PASS');

$db = new PDO("$dbtype:dbname=$dbname;host=$host", $dbuser, $dbpass); 

$table = getenv('DATABASE_TABLE');
$url = getenv('ROOT_URL');
$title = getenv('TITLE');
$main_label = getenv('MAIN_LABEL');
$thanks_label = getenv('THANKS_LABEL');