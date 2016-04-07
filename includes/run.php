<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	if (isset($_GET['email'])) {
		$value = $_GET['email'];
		if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
			$email = $_GET['email'];
		} else {
			$email = '';
		}
	} else {
		$email = '';
	}
	$amount = '';
	include('form.php');
} else {
	$valid = TRUE;
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$valid = FALSE;
	}

	$amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, 
              FILTER_FLAG_ALLOW_FRACTION);
	if (!filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT, 
              FILTER_FLAG_ALLOW_FRACTION)) {
    	$valid = FALSE;
	}

	$charge_if_on_file = filter_var($_POST['charge_if_on_file'], FILTER_SANITIZE_NUMBER_INT);
	if ($charge_if_on_file === '') {
		$charge_if_on_file = 0;
	}

	if ( isset($email) && isset($amount) && $valid == TRUE) {
		include('config.php');
		$sql = "INSERT INTO `{$table}` (email, amount, created, charge_if_on_file) VALUES ('$email', '$amount', NOW(), '$charge_if_on_file' )";

		if(!$result = $db->query($sql)){
			die('There was an error running the query [' . $db->error . ']');
		} else {
			$amount = number_format($amount, 2);
		}

		include('message.php');
	} else {
		include('form.php');
	}
}

?>