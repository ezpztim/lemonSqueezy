<?php

	class Violation {

		private $conn;

		function __construct() {

			include("db_config.php");
			$this->conn = $conn;

		}
		function createViolation($conn, $idovi, $razlog, $prestup) {

			$idOglas = $idovi["idOglas"];
			$idKorisnika = $idovi["idKorisnika"];

			if ($prestup) $sql3 = "INSERT INTO prestup (idOglas, idKorisnika, Razlog, jeVeliki) VALUES (?, ?, ?, 1)";
			else $sql3 = "INSERT INTO prestup (idOglas, idKorisnika, Razlog, jeVeliki) VALUES (?, ?, ?, 0)";

			$stmt = $conn->prepare($sql3);
			$stmt->bind_param('iis', $idOglas, $idKorisnika, $razlog); 

			if(!$stmt->execute()){
				mysqli_rollback($conn);
				mysqli_close($conn);

				$_SESSION['msg'] = "Odbijanje oglasa nije uspelo!<br>Pokušajte ponovo.";

				header("Location: admin.php");
				exit();
			}

			if ($prestup) $_SESSION['msg'] .= "<br>Broj prestupa je uvećan.";
		}

		function getUserViolationNumber($conn, $id) {

			$sql = "SELECT * FROM prestup WHERE idKorisnika = ? AND jeVeliki = 1";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();

			return $stmt->num_rows;
		}

		function getViolationForAdd($idOglas) {
			
			$sql = "SELECT Razlog FROM prestup WHERE idOglas = ?";

			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param('i', $idOglas);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($razlog);
			$stmt->fetch();

			mysqli_close($this->conn);

			return $razlog;
		}

		function removeViolation($conn, $idOglas, $overrideinsert = false) {

			$sql = "SELECT id, jeVeliki FROM prestup WHERE idOglas = ?";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $idOglas);

			if (!$stmt->execute()) throw new Exception("Dohvatanje prestupa nije uspelo");	

			$stmt->store_result();
			$stmt->bind_result($prestupId, $prestupJeVeliki);
			$stmt->fetch();

			if ($prestupJeVeliki == 1 && !$overrideinsert) $sql1 = "UPDATE prestup SET idOglas = 0 WHERE id = ?";
			else $sql1 = "DELETE FROM prestup WHERE id = ?";

			$stmt1 = $conn->prepare($sql1);
			$stmt1->bind_param('i', $prestupId);

			if (!$stmt1->execute()) throw new Exception("Izmena/brisanje prestupa nije uspelo");
		}

		function removeAllViolationsUser($conn, $idKorisnika) {
			$sql = "SELECT idOglas FROM prestup WHERE idKorisnika = ?";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $idKorisnika);
			if(!$stmt->execute()) throw new Exception("Uklanjanje korisnika nakon 3 velika prestupa nije uspelo.");
			$stmt->store_result();	
			$stmt->bind_result($idOglas); 

			while ($stmt->fetch()) {
				try {
					$this->removeViolation($conn, $idOglas, true);
				} catch (Exception $e) {
					throw new Exception("Brisanje svih oglasa korisnika nakon 3 velika<br>prestupa nije uspelo.<br>" . $e->getMessage());		
				}
			}
		}
	}

?>