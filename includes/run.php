<?php

require_once( 'includes/config.php' );

if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
	if ( isset( $_GET['email'] ) ) {
		$value = $_GET['email'];
		if ( filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			$email = $_GET['email'];
		} else {
			$email = '';
		}
	} else {
		$email = '';
	}
	$amount = '';
	$name   = '';
	require_once( 'includes/form.php' );
} else {
	$valid = true;
	$email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
	if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$valid = false;
	}

	$amount = filter_var( $_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	if ( ! filter_var( $amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) ) {
		$valid = false;
	}

	if ( isset( $_POST['name'] ) ) {
		$name = filter_var( $_POST['name'], FILTER_SANITIZE_STRING );
	} else {
		$name = '';
	}

	if ( ! isset( $_POST['charge_if_on_file'] ) ) {
		$charge_if_on_file = 0;
	} else {
		$charge_if_on_file = filter_var( $_POST['charge_if_on_file'], FILTER_SANITIZE_NUMBER_INT );
	}

	if ( isset( $email ) && isset( $amount ) && true === $valid ) {
		$sql = "INSERT INTO {$table} (email, name, amount, created, charge_if_on_file, campaign) VALUES ('$email', '$name', '$amount', NOW(), '$charge_if_on_file', '$campaign' )";
		if ( ! $result = $db->query( $sql ) ) {
			die( 'There was an error running the query [' . print_r( $db->errorInfo() ) . ']' );
		} else {
			$amount = number_format( $amount, 2 );
		}
		require_once( 'includes/message.php' );
	} else {
		require_once( 'includes/form.php' );
	}
}
