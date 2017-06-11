<?php

	require_once './app/models/User.php';
	$user = new User();

	$user->checkPermLoggedIn();


if(isSet($_POST['submit'])) {
	$do_login = true;
	include_once 'do_login.php';
}

?>