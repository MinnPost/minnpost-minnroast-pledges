<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = new Dotenv\Dotenv( __DIR__ . '/../' );
if ( file_exists( get_include_path() . '.env' ) ) {
	$dotenv->load();
}

$database_url = getenv( 'DATABASE_URL' );

$database_url_parts = parse_url($database_url);
$dbtype = isset( $database_url_parts['scheme'] ) ? $database_url_parts['scheme'] : getenv( 'DATABASE_TYPE' );
$dbname = isset( $database_url_parts['database'] ) ? $database_url_parts['database'] : getenv( 'DATABASE_NAME' );
$host = isset( $database_url_parts['host'] ) ? $database_url_parts['host'] : getenv( 'DATABASE_HOST' );
$dbuser = isset( $database_url_parts['user'] ) ? $database_url_parts['user'] : getenv( 'DATABASE_USER' );
$dbpass = isset( $database_url_parts['pass'] ) ? $database_url_parts['pass'] : getenv( 'DATABASE_PASS' );

$db = new PDO( "$dbtype:dbname=$dbname;host=$host", $dbuser, $dbpass ); 

$table           = getenv( 'DATABASE_TABLE' );
$allowed_domains = explode( ',', getenv( 'ALLOWED_DOMAINS' ) );
$salesforce_id   = getenv( 'SALESFORCE_ID' );

$board_show_count = filter_var( getenv( 'BOARD_SHOW_COUNT' ), FILTER_VALIDATE_BOOLEAN );
$board_show_names = filter_var( getenv( 'BOARD_SHOW_NAMES' ), FILTER_VALIDATE_BOOLEAN );

$board_show_total_heading  = filter_var( getenv( 'BOARD_SHOW_TOTAL_HEADING' ), FILTER_VALIDATE_BOOLEAN );
$board_show_names_heading  = filter_var( getenv( 'BOARD_SHOW_NAMES_HEADING' ), FILTER_VALIDATE_BOOLEAN );
$board_show_pledge_heading = filter_var( getenv( 'BOARD_SHOW_PLEDGE_HEADING' ), FILTER_VALIDATE_BOOLEAN );

$image_url = getenv( 'DEFAULT_IMAGE_URL' );


// remove www in case we forget to add that to the allowed domains list
$server_name = str_replace( 'www.', '', $_SERVER['HTTP_HOST'] );

if ( ! isset( $server_name ) || ! in_array( $server_name, $allowed_domains, true ) ) {
	header( $_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request' );
	exit;
} else {
	$protocol = stripos( $_SERVER['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://';
	$url      = $protocol . $server_name;
	if ( false !== $salesforce_id ) {
		$sql = $db->prepare( "SELECT id, title, main_label, thanks_label, image_url FROM campaigns WHERE salesforce_id = '" . $salesforce_id . "' LIMIT 1" );
	} else {
		$sql = $db->prepare( "SELECT id, title, main_label, thanks_label, image_url FROM campaigns WHERE url = '" . $server_name . "' LIMIT 1" );
	}
	$sql->execute();
	$row          = $sql->fetch();
	$title        = isset( $row['title'] ) ? $row['title'] : '';
	$main_label   = isset( $row['main_label'] ) ? $row['main_label'] : '';
	$thanks_label = isset( $row['thanks_label'] ) ? $row['thanks_label'] : '';
	$campaign     = isset( $row['id'] ) ? $row['id'] : '';
	if ( isset( $row['image_url'] ) ) {
		$image_url = $row['image_url'];
	}
}
