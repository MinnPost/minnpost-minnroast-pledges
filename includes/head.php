<?php
echo 'files exist? ' .
file_exists('includes/config.php');
//require_once('/../../../../includes/config.php');
?>
<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie ie6 lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="en" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie ie7 lt-ie10 lt-ie9 lt-ie8" lang="en" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie ie8 lt-ie10 lt-ie9" lang="en" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie ie9 lt-ie10" lang="en" xmlns:og="http://opengraphprotocol.org/schema/"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" xmlns:og="http://opengraphprotocol.org/schema/"> <!--<![endif]-->

<head>
<title>MinnPost | <?php echo $title; ?></title>
<link rel="shortcut icon" href="//www.minnpost.com/sites/default/themes/siteskin/favicon.ico" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="stylesheet" href="bower_components/minnpost-styles/dist/minnpost-styles.min.css">
<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="mp">

  <header class="minnpost-page-container">
        <a href="<?php echo $url; ?>" class="logo clearfix">
            <img src="https://www.minnpost.com/sites/default/themes/siteskin/inc/images/logo.png" alt="MinnPost">
        </a>
    </header>

    <main class="minnpost-page-container">