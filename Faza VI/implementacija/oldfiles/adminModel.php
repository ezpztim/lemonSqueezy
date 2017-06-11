<?php
	include 'config.php';

	if(!isSet($_SESSION['username'])) {
		$_SESSION['url'] = $_SERVER['REQUEST_URI'];
		header("Location: login.php");
		exit;
	}
	else if ($_SESSION['userisadmin'] == 0) {
		if(isset($_SESSION['url'])) 
			$url = $_SESSION['url'];
		else {
			$url = "nalog.php";
		}
		$_SESSION['url'] = $_SERVER['REQUEST_URI'];
		header("Location: $url");
		exit;
	}
	$_SESSION['url'] = $_SERVER['REQUEST_URI'];
?>

<?php
	//$sql = "SELECT id, Naziv, DatumObjave, idKorisnika FROM oglas WHERE status = 'Čeka potvrdu'";
	$sql = "SELECT o.id, o.Naziv, o.DatumObjave, o.idKorisnika, u.name, u.surname, COUNT(p.idOglas) FROM oglas AS o, users AS u, prestup AS p WHERE status = 'Čeka potvrdu' AND u.id = o.idKorisnika AND p.idKorisnika = u.id AND p.jeVeliki = 1 GROUP BY o.id";

	include("db_config.php");

	mysqli_autocommit($conn, FALSE);

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stmt->store_result();

	mysqli_commit($conn);
	mysqli_close($conn);
?>