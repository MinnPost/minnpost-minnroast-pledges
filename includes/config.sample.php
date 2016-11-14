<?php

$db = new mysqli('host', 'username', 'password', 'dbname');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$table = 'tablename';
$url = 'http://mainurl.com';
$title = 'Site Title';
$main_label = "Pledge to support ---";
$thanks_label = "Thank you for supporting ---";