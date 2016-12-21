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
$allowed_domains = explode(',', getenv('ALLOWED_DOMAINS'));
$salesforce_id = getenv('SALESFORCE_ID');

if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_domains)) {
    header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
    exit;
} else {
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$url = $protocol . $_SERVER['HTTP_HOST'];
	if ($salesforce_id != FALSE) {
		$sql = $db->prepare("SELECT id, title, main_label, thanks_label FROM campaigns WHERE salesforce_id = '" . $salesforce_id . "' LIMIT 1");
	} else {
		$sql = $db->prepare("SELECT id, title, main_label, thanks_label FROM campaigns WHERE url = '" . $_SERVER['HTTP_HOST'] . "' LIMIT 1");	
	}
	$sql->execute();
	$row = $sql->fetch();
	$title = $row['title'];
	$main_label = $row['main_label'];
	$thanks_label = $row['thanks_label'];
	$campaign = $row['id'];
}