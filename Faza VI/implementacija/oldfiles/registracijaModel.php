<?php

include("./app/models/User.php");
$user = new User();

$user->checkPermLoggedIn();

function validatephp() {
	global $errorEmpty;
	$check = true;
	if (empty($_POST['name'])) {
		$errorname = true;
		$check = false;
	}
	if (empty($_POST['surname'])) {
		$errorsurname = true;
		$check = false;
	}
	if (empty($_POST['email'])) {
		$erroremail = true;
		$check = false;
	}
	if (empty($_POST['password'])) {
		$errorpassword = true;
		$check = false;
	}
	if (!$check) $errorEmpty = true;
	return $check;
}
$errorExist = false;
$errorEmpty = false;
if (isset($_POST['submit'])) {
	if (validatephp()) {
		$errorEmpty = true;

		$err = $user->createNewUser($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password']);

		if ($err == -1) $errorExist = true;

}
?>