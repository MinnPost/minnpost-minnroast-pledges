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

$board_show_count = filter_var( getenv( 'BOARD_SHOW_COUNT' ), FILTER_VALIDATE_BOOLEAN );
$board_show_names = filter_var( getenv( 'BOARD_SHOW_NAMES' ), FILTER_VALIDATE_BOOLEAN );

// remove www in case we forget to add that to the allowed domains list
$server_name = str_replace('www.', '', $_SERVER['HTTP_HOST']);

if (!isset($server_name) || !in_array($server_name, $allowed_domains)) {
    header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
    exit;
} else {
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	$url = $protocol . $server_name;
	if ($salesforce_id != FALSE) {
		$sql = $db->prepare("SELECT id, title, main_label, thanks_label FROM campaigns WHERE salesforce_id = '" . $salesforce_id . "' LIMIT 1");
	} else {
		$sql = $db->prepare("SELECT id, title, main_label, thanks_label FROM campaigns WHERE url = '" . $server_name . "' LIMIT 1");	
	}
	$sql->execute();
	$row = $sql->fetch();
	$title = $row['title'];
	$main_label = $row['main_label'];
	$thanks_label = $row['thanks_label'];
	$campaign = $row['id'];
}