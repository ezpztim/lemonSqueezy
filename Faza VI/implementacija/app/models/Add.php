
<?php

	class Add {

		function getForIndexPage($conn) {

			$sql = "SELECT o.id, o.Naziv, o.DatumObjave, o.CenaMesec, o.Kvadratura, o.Tip, (SELECT Ime FROM slika WHERE idOglas = o.id LIMIT 1) AS Slika FROM oglas AS o WHERE o.Status = 'Odobren' ORDER BY DatumObjave DESC LIMIT 4";
			
			$sql1 = "SELECT o.id, o.Naziv, o.DatumObjave, o.CenaMesec, o.Kvadratura, o.Tip, p.Iznos, p.Razlog, (SELECT Ime FROM slika WHERE idOglas = o.id LIMIT 1) AS Slika FROM popust AS p, oglas AS o WHERE p.idOglas = o.id AND o.Status = 'Odobren' ORDER BY o.DatumObjave DESC LIMIT 4";


			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();

			$stmt1 = $conn->prepare($sql1);
			$stmt1->execute();
			$result1 = $stmt1->get_result();

			return array('result' => $result, 'result1' => $result1);
		}

		function getForAdminPage($conn) {

			//$sql = "SELECT o.id, o.Naziv, o.DatumObjave, o.idKorisnika, u.name, u.surname, COUNT(p.idOglas) AS brprestupa FROM oglas AS o, users AS u, prestup AS p WHERE status = 'Čeka potvrdu' AND u.id = o.idKorisnika AND p.idKorisnika = u.id AND p.jeVeliki = 1 GROUP BY o.id";
			$sql = "SELECT g.id, g.Naziv, g.DatumObjave, g.idKorisnika, g.name, g.surname, COUNT(p.id) AS brprestupa FROM (SELECT o.id, o.Naziv, o.DatumObjave, o.idKorisnika, u.name, u.surname FROM oglas AS o, users AS u WHERE o.status = 'Čeka potvrdu' AND u.id = o.idKorisnika) AS g LEFT JOIN prestup as p ON g.idKorisnika = p.idKorisnika AND p.jeVeliki = 1 GROUP BY g.id";

			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
			
			return $result;
		}

		function getForUserPage($conn) {

			$sql = "SELECT id, Naziv, Status, Razlog FROM (SELECT o.id, o.Naziv, o.Status, p.Razlog FROM oglas AS o, prestup AS p WHERE o.idKorisnika = ? AND o.Status = 'Odbijen' AND p.idOglas = o.id UNION SELECT o.id, o.Naziv, o.Status, '' AS Razlog FROM oglas AS o WHERE o.idKorisnika = ? AND o.Status <> 'Odbijen') AS v GROUP BY id";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ii', $_SESSION['userid'], $_SESSION['userid']);
			$stmt->execute();

			$result = $stmt->get_result();
			
			return $result;
		}

		function getForFavouritesPage($conn) {
			$results = [];

			if (isset($_COOKIE['favoriti'])) {
				$arr = explode(";", $_COOKIE['favoriti']);

				if (count($arr)> 0) {
					for ($i = 0; $i < count($arr); $i++) { 

						$stmt = $conn->prepare("SELECT *, (SELECT Ime FROM slika WHERE idOglas = ? LIMIT 1) AS Slika FROM oglas AS o WHERE id = ?");
						$stmt->bind_param("ii", $arr[$i], $arr[$i]);
						$stmt->execute();
						array_push($results, $stmt->get_result());

					}
				}
			}

			return $results;
		}

		function allowAdd($conn, $idOglas) {

			$sql1 = "SELECT * FROM oglas WHERE id = ? AND Status = 'Čeka potvrdu'";

			include("db_config.php");

			$stmt = $conn->prepare($sql1);
			$stmt->bind_param('i', $idOglas);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 1) {		
				$sql2 = "UPDATE oglas SET Status = 'Odobren' WHERE id = ?";	

				$stmt = $conn->prepare($sql2);
				$stmt->bind_param('i', $idOglas);
				if(!$stmt->execute()) throw new Exception("");				

				$_SESSION['msg'] = "Oglas je uspešno odobren.";
			}
			else $_SESSION['msg'] = "Status oglasa je već promenjen.";

		}

		function rejectAdd($conn, $idOglas) {

			$sql1 = "SELECT idKorisnika FROM oglas WHERE id = ? AND Status = 'Čeka potvrdu'";	

			$stmt = $conn->prepare($sql1);
			$stmt->bind_param('i', $idOglas); 
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($idKorisnika);
			$stmt->fetch();

			if ($stmt->num_rows == 1) {			

				$sql2 = "UPDATE oglas SET Status = 'Odbijen' WHERE id = ?";	

				$stmt = $conn->prepare($sql2);
				$stmt->bind_param('i', $idOglas);

				if(!$stmt->execute()) throw new Exception("Odbijanje oglasa nije uspelo!<br>Pokušajte ponovo.");		

				$_SESSION['msg'] = "Oglas je uspešno odbijen.";

				/*

				$sql4 = "SELECT idOglas FROM prestup WHERE idKorisnika = ? AND jeVeliki = 1";

				$stmt1 = $conn->prepare($sql4);
				$stmt1->bind_param("i", $idKorisnika);
				$stmt1->execute();
				$stmt1->store_result();

				if ($stmt1->num_rows >= 3) {
					//obrisi sve
					//return nesto sto ce da trigeruje brisanje u kontroleru
				}*/
			}
			else throw new Exception("Status oglasa je već promenjen.");

			return array("idOglas"=>$idOglas, "idKorisnika"=>$idKorisnika);
		}

		function deleteDir($dirPath) {
			if (empty($dirPath) || file_exists($dirPath) === false) {
				throw new InvalidArgumentException("");
			}
			if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
				$dirPath .= '/';
			}
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($dirPath);
		}

		function getAdd($conn, $id) {
			$sql = "SELECT * FROM oglas WHERE id = ?";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $id);
			if (!$stmt->execute()) throw new Exception("Dohvatanje oglasa (id: $id) nije uspelo.");		
			$result = $stmt->get_result();

			return $result;
		}

		function newAdd($conn, $title, $type, $location, $street, $price_day, $price, $area, $roomNumber, $furnished, $heating, $pets, $contact, $cellar, $phone, $parking, $ac, $terrace, $cable, $internet, $garage, $lift, $pool, $alarm, $yard, $inConstruction, $recent, $description) {

			if (!isset($description) || $description == "") $description = "Ne postoji opis za oglas.";

			$status = "Čeka potvrdu";
			$userid = $_SESSION['userid'];

			$sql1 = "INSERT INTO oglas (Naziv, Tip, Mesto, Ulica, Cena1Dan, CenaMesec, Kvadratura, BrSoba, Namestenost, Grejanje, Ljubimci, KontaktTelefon, Podrum, Telefon, Parking, Klima, Terasa, Kablovska, Internet, Garaza, Lift, Bazen, Alarm, Dvoriste, Uizgradnji, Novogradnja, Opis, Status, idKorisnika) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

			$stmt = $conn->prepare($sql1);
			$stmt->bind_param('ssssiiidssssiiiiiiiiiiiiiissi', $title, $type, $location, $street, $price_day, $price, $area, $roomNumber, $furnished, $heating, $pets, $contact, $cellar, $phone, $parking, $ac, $terrace, $cable, $internet, $garage, $lift, $pool, $alarm, $yard, $inConstruction, $recent, $description, $status, $userid);
			
			if(!$stmt->execute()) throw new Exception("Ubacivanje oglasa u bazu nije uspelo");	

			$last_id = $stmt->insert_id;	

			mkdir("./oglasi/$last_id");
			mkdir("./oglasi/$last_id/slike");

			$file = fopen("oglasi/$last_id/index.php", "w"); 
			$page = "<?php\n \$id = $last_id; include('../../generator.php'); ?>";
			fwrite($file, $page);
			fclose($file);

			return $last_id;
		}

		function changeAdd($conn, $idOglas, $title, $type, $location, $street, $price_day, $price, $area, $roomNumber, $furnished, $heating, $pets, $contact, $cellar, $phone, $parking, $ac, $terrace, $cable, $internet, $garage, $lift, $pool, $alarm, $yard, $inConstruction, $recent, $description) {

			if (!isset($description) || $description == "") $description = "Ne postoji opis za oglas.";

			$status = "Čeka potvrdu";

			$sql = "UPDATE oglas SET Naziv = ?, Tip = ?, Mesto = ?, Ulica = ?, Cena1Dan = ?, CenaMesec = ?, Kvadratura = ?, BrSoba = ?, Namestenost = ?, Grejanje = ?, Ljubimci = ?, KontaktTelefon = ?, Podrum = ?, Telefon = ?, Parking = ?, Klima = ?, Terasa = ?, Kablovska = ?, Internet = ?, Garaza = ?, Lift = ?, Bazen = ?, Alarm = ?, Dvoriste = ?, Uizgradnji = ?, Novogradnja = ?, Opis = ?, Status = ? WHERE id = ?";
			
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('ssssiiidssssiiiiiiiiiiiiiissi', $title, $type, $location, $street, $price_day, $price, $area, $roomNumber, $furnished, $heating, $pets, $contact, $cellar, $phone, $parking, $ac, $terrace, $cable, $internet, $garage, $lift, $pool, $alarm, $yard, $inConstruction, $recent, $description, $status, $idOglas);

			if(!$stmt->execute()) throw new Exception("Izmena oglasa iz baze nije uspelo");					
		}

		function deleteAdd($conn, $id) {

			$sql = "DELETE FROM oglas WHERE id = ?";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $id);
			if(!$stmt->execute()) throw new Exception("Brisanje oglasa nije uspelo");
			$stmt->store_result();					

			$this->deleteDir("./oglasi/$id");

		}

		function deleteAllAdsFromUser($conn, $idKorisnika) {
			$sql = "SELECT id FROM oglas WHERE idKorisnika = ?";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $idKorisnika);
			if(!$stmt->execute()) throw new Exception("Uklanjanje korisnika nakon 3 velika prestupa nije uspelo.");
			$stmt->store_result();	
			$stmt->bind_result($idOglas); 

			$ret = [];

			while ($stmt->fetch()) {
				array_push($ret, $idOglas);
				try {
					$this->deleteAdd($conn, $idOglas);
				} catch (Exception $e) {
					throw new Exception("Brisanje svih oglasa korisnika nakon 3 velika<br>prestupa nije uspelo.<br>" . $e->getMessage());		
				}
			}
			return $ret;
		}

		function searchAd($conn, $page_number, $item_per_page, $idOglas, $type, $location, $priceFrom, $priceTo, $areaFrom, $areaTo, $furnished, $heating, $pets, $roomNumFrom, $roomNumTo, $cellar, $phone, $parking, $ac, $terrace, $cable, $internet, $garage, $lift, $pool, $alarm, $yard, $in_construction, $recent, $special, $sortby) {

			$position = (($page_number-1) * $item_per_page);

			$first = false;

			$arr = array("o.Mesto = ?"=>$location, "o.Tip = ?"=>$type, "o.CenaMesec >= ?"=>$priceFrom, "o.CenaMesec <= ?"=>$priceTo, "o.Kvadratura >= ?"=>$areaFrom, "o.Kvadratura <= ?"=>$areaTo, "o.BrSoba >= ?"=>$roomNumFrom, "o.BrSoba <= ?"=>$roomNumTo, "o.Namestenost = ?"=>$furnished, "o.Grejanje = ?"=>$heating, "o.Ljubimci = ?"=>$pets, "o.id = ?"=>$idOglas);

			$sql = "SELECT SQL_CALC_FOUND_ROWS o.id, o.Naziv, o.Mesto, o.Ulica, o.CenaMesec, o.Kvadratura, o.Tip, o.BrSoba, o.Namestenost, o.Grejanje, o.DatumObjave, (SELECT Ime FROM slika WHERE idOglas = o.id LIMIT 1) AS Slika, (SELECT Iznos FROM popust WHERE idOglas = o.id) AS Iznos, (SELECT Razlog FROM popust WHERE idOglas = o.id) AS Razlog FROM oglas AS o, popust AS p WHERE o.Status = 'Odobren' ";

			$par = "ssiiiiddsssiiiiiiiiiiiiiii";
			$i = 0;
			$types = "";
			$substr = [];

			foreach($arr as $key=>$value){
				if ($value != "") {
					if ($first) {
						$sql .= " WHERE " . $key . " ";
						$first = false;
					} else $sql .= "AND " . $key . " ";
					$types .= $par[$i];
					array_push($substr, $value);
				}
				$i++;
			}

			if ($special) if (!$first) $sql .= " AND p.idOglas = o.id "; else {$first = false; $sql .= " WHERE p.idOglas = o.id ";}

			if ($cellar) if (!$first) $sql .= "AND o.Podrum = 1 "; else {$first = false; $sql .= " WHERE o.Podrum = 1 ";}
			if ($parking) if (!$first) $sql .= "AND o.Parking = 1 "; else {$first = false; $sql .= " WHERE o.Parking = 1 ";}
			if ($garage) if (!$first) $sql .= "AND o.Garaza = 1 "; else {$first = false; $sql .= " WHERE o.Garaza = 1 ";}
			if ($ac) if (!$first) $sql .= "AND o.Klima = 1 "; else {$first = false; $sql .= " WHERE o.Klima = 1 ";}
			if ($terrace) if (!$first) $sql .= "AND o.Terasa = 1 "; else {$first = false; $sql .= " WHERE o.Terasa = 1 ";}
			if ($cable) if (!$first) $sql .= "AND o.Kablovska = 1 "; else {$first = false; $sql .= " WHERE o.Kablovska = 1 ";}
			if ($internet) if (!$first) $sql .= "AND o.Internet = 1 "; else {$first = false; $sql .= " WHERE o.Internet = 1 ";}
			if ($phone) if (!$first) $sql .= "AND o.Telefon = 1 "; else {$first = false; $sql .= " WHERE o.Telefon = 1 ";}
			if ($lift) if (!$first) $sql .= "AND o.Lift = 1 "; else {$first = false; $sql .= " WHERE o.Lift = 1 ";}
			if ($pool) if (!$first) $sql .= "AND o.Bazen = 1 "; else {$first = false; $sql .= " WHERE o.Bazen = 1 ";}
			if ($alarm) if (!$first) $sql .= "AND o.Alarm = 1 "; else {$first = false; $sql .= " WHERE o.Alarm = 1 ";}
			if ($yard) if (!$first) $sql .= "AND o.Dvoriste = 1 "; else {$first = false; $sql .= " WHERE o.Dvoriste = 1 ";}
			if ($in_construction) if (!$first) $sql .= "AND o.Uizgradnji = 1 "; else {$first = false; $sql .= " WHERE o.Uizgradnji = 1 ";}
			if ($recent) if (!$first) $sql .= "AND o.Novogradnja = 1 "; else {$first = false; $sql .= " WHERE o.Novogradnja = 1 ";}

			$sql .= " GROUP BY o.id";

			if ($sortby != "") {
				if($sortby == "cenaOpadajuce") $sql .= " ORDER BY o.CenaMesec DESC ";
				if($sortby == "cenaRastuce") $sql .= " ORDER BY o.CenaMesec ASC ";
				if($sortby == "datumOpadajuce") $sql .= " ORDER BY o.DatumObjave DESC ";
				if($sortby == "datumRastuce") $sql .= " ORDER BY o.DatumObjave ASC ";
				if($sortby == "kvadraturaOpadajuce") $sql .= " ORDER BY o.Kvadratura DESC ";
				if($sortby == "kvadraturaRastuce") $sql .= " ORDER BY o.Kvadratura ASC ";
			}
			else $sql .= " ORDER BY o.DatumObjave DESC ";

			$sql .= "LIMIT $position, $item_per_page";
			/*$types .= "ii";
			array_push($substr, $position);
			array_push($substr, $item_per_page);*/
			//echo "$sql<br>";

			$refarr = array();
			$refarr[] = & $types;
			$n = count($substr);
			for ($i = 0; $i < $n; $i++) $refarr[] = & $substr[$i];
			//$n = count($refarr);
			//for ($i = 0; $i < $n; $i++) echo "$refarr[$i]<br>";

			$stmt = $conn->prepare($sql);
			if ($n > 0) call_user_func_array(array($stmt, 'bind_param'), $refarr);
			$stmt->execute();
			$result = $stmt->get_result();

			$stmt1 = $conn->prepare("SELECT FOUND_ROWS()");
			$stmt1->execute();
			$stmt1->store_result();
			$stmt1->bind_result($br);
			$stmt1->fetch();
			//echo $br;

			//echo $result->num_rows;
			return array("result"=>$result, "num"=>$br);
		}

		private $cookie_name = "favoriti";
		private $cookie_time = (3600 * 24 * 30);

		function addToFavourites($conn, $id) {

			$stmt = $conn->prepare("SELECT * FROM oglas WHERE id = ?");
			$stmt->bind_param("i", $id);
			if (!$stmt->execute()) echo "Nije uspelo dodavanje oglasa (id: $id) u favorite! Pokušajte ponovo.";
			$stmt->store_result();

			if ($stmt->num_rows == 1) {

				if (isset($_COOKIE[$this->cookie_name])) {

					$val = $_COOKIE[$this->cookie_name];

					$arr = explode(";", $val);

					for ($i = 0; $i < count($arr); $i++) { 

						if (((int)$arr[$i]) == ((int)$id)) { 
							echo "Oglas (id: ". $id . ") je već dodat u favorite.";
							return;
						}
					}

					setcookie ($this->cookie_name, $val . ";" . $id, time() + $this->cookie_time);
				} else {
					setcookie ($this->cookie_name, $id, time() + $this->cookie_time);
				}
			} else echo "Ne postoji oglas (id: $id)!";
		}

		function removeFromFavourites($conn, $id) {

			$stmt = $conn->prepare("SELECT * FROM oglas WHERE id = ?");
			$stmt->bind_param("i", $id);
			if (!$stmt->execute()) echo "Nije uspelo uklanjanje oglasa (id: $id) iz favorite! Pokušajte ponovo.";
			$stmt->store_result();

			if ($stmt->num_rows == 1) {
				if (isset($_COOKIE[$this->cookie_name])) {

					$val = str_replace("".$id.";", "", $_COOKIE[$this->cookie_name]);
					$val = str_replace(";".$id, "", $val);
					$val = str_replace("".$id, "", $val);
					setcookie ($this->cookie_name, $val, time() + $this->cookie_time);

				} else {
					echo "Nije uspelo uklanjanje oglasa (id: $id) iz favorite! Pokušajte ponovo.";
				}
			} else echo "Ne postoji oglas (id: $id)!";
		}

		function checkPermAndRedirect($ad_result) {
			$row = $ad_result->fetch_assoc();
			$status = $row['Status'];
			$userid = $row['idKorisnika'];
			if (strcmp($status, "Odbijen") == 0 || strcmp($status, "Čeka potvrdu") == 0) {
				if (isset($_SESSION['userid'])) {
					if ($userid != $_SESSION['userid'] && $_SESSION['userisadmin'] != 1) {
						if(isset($_SESSION['url'])) 
							$url = $_SESSION['url'];
						else {
							$url = "index.php";
						}
						header("Location: $url");
						exit;
					}
				} else {
					if(isset($_SESSION['url'])) 
						$url = $_SESSION['url'];
					else {
						$url = "index.php";
					}
					header("Location: $url");
					exit;
				}
			}
			return $row;
		}
	}

?>