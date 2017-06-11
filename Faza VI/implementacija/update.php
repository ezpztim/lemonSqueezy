<?php 

	require_once "app/controllers/addController.php";
	$cont = new AddController();
	$cont->change();
/*
function validatephp() {
	global $errorEmpty;
	$check = true;
	if (empty($_POST['naziv'])) {
		$errorNaziv = true;
		$check = false;
	}
	if (empty($_POST['tip-nekretnine'])) {
		$errorTipNekretnine = true;
		$check = false;
	}
	if (empty($_POST['lokacija'])) {
		$errorlokacija = true;
		$check = false;
	}
	if (empty($_POST['cena'])) {
		$errorCena = true;
		$check = false;
	}
	if (empty($_POST['kvadratura'])) {
		$errorKvadratura = true;
		$check = false;
	}
	if (empty($_POST['number'])) {
		$errorBrojSoba = true;
		$check = false;
	}
	if (empty($_POST['namestenost'])) {
		$errorNamestenost = true;
		$check = false;
	}
	if (empty($_POST['grejanje'])) {
		$errorGrejanje = true;
		$check = false;
	}
	if (empty($_POST['ljubimci'])) {
		$errorLjubimci = true;
		$check = false;
	}
	if (!$check) $errorEmpty = true;
	return $check;
}
*/
?>