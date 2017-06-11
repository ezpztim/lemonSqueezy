<!--Napravio: Aleksa Funduk 2014/0219-->

<?php 

	require_once "app/controllers/userController.php";
	$cont = new UserController();
	$cont->generateAdminPage();

?>
