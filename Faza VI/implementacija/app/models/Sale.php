<?php

	class Sale {

		function getSale($id, $getid = false) {
			include("db_config.php");

			$sql = "SELECT id, Iznos, Razlog FROM popust WHERE idOglas = ?";	

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$result = $stmt->get_result();

			mysqli_close($conn);

			if ($getid) {

				$row = $result->fetch_assoc();
				return $row['id'];

			} else return $result;
		}

		function getSale1($conn, $idOglas) {
			$sql = "SELECT id, Iznos, Razlog FROM popust WHERE idOglas = ?";	

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $idOglas);

			if (!$stmt->execute()) throw new Exception("Dohvatanje popusta nije uspelo");	

			$result = $stmt->get_result();

			return $result;
		}

		function deleteSale($conn, $idOglas) {

			$res = $this->getSale1($conn, $idOglas);

			if ($res && $res->num_rows == 1) {
				$stmt = $conn->prepare("DELETE FROM popust WHERE idOglas = ?");
				$stmt->bind_param('i', $idOglas);

				if (!$stmt->execute()) throw new Exception("Brisanje popusta nije uspelo");
			}
		}

		function deleteAllSalesFromAdIdArray($conn, $arr) {
			for($i = 0; $i < count($arr); $i++) {
				try {
					$this->deleteSale($conn, $arr[$i]);
				} catch (Exception $e) {
					throw new Exception("Brisanje svih popusta korisnika nakon 3 velika<br>prestupa nije uspelo.<br>" . $e->getMessage());					
				}
			}
		}

		function insertOrUpdateSale($conn, $val, $reason, $idOglas) {

			$res = $this->getSale1($conn, $idOglas);

			if ($res && $res->num_rows == 1) {
				$stmt = $conn->prepare("UPDATE popust SET Iznos = ?, Razlog = ? WHERE idOglas = ?");
			} else { 
				$stmt = $conn->prepare("INSERT INTO popust (Iznos, Razlog, idOglas) VALUES (?, ?, ?)");
			}
			
			$stmt->bind_param('isi', $val, $reason, $idOglas);

			if (!$stmt->execute()) throw new Exception("Izmena/dodavanje popusta nije uspelo");
		}

		function changeSale($conn, $checked, $val, $reason, $idOglas) {

			if ($checked) $this->insertOrUpdateSale($conn, $val, $reason, $idOglas);
			else $this->deleteSale($conn, $idOglas);
		}
		
	}

?>