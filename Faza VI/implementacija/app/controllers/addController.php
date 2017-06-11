<?php 

	require_once 'Controller.php';
	
	class AddController extends Controller {

		private $conn;
		private $item_per_page;

		function __construct() {

			if (is_file("db_config.php")) include("db_config.php");
			else include ("../../db_config.php");
			$this->conn = $conn;
			$this->item_per_page = $item_per_page;
		}

		function index() {
			//prebaciti u neki drugi kontroler??
			$user = $this->model("User");
			$_SESSION['url'] = $_SERVER['REQUEST_URI'];

			mysqli_autocommit($this->conn, FALSE);

			$add = $this->model("Add");
			$arr = $add->getForIndexPage($this->conn);

			mysqli_commit($this->conn);
			mysqli_close($this->conn);
			$this->view("indexView", $arr);
		}

		function adPage($id) {
			//dependency injection changeAdd()
			$user = $this->model("User");

			mysqli_autocommit($this->conn, FALSE);

			try {
				$add = $this->model("Add");
				$ad = $add->getAdd($this->conn, $id);

				$row = $add->checkPermAndRedirect($ad);
				$useremail = $user->getEmail($this->conn, $row['idKorisnika']);
				$_SESSION['url'] = $_SERVER['REQUEST_URI'];

				$img = $this->model("Image");
				$images = $img->getImages($this->conn, $id);

				$sale = $this->model("Sale");
				$s = $sale->getSale1($this->conn, $id);				

				mysqli_commit($this->conn);
				$this->view("oglasView", array("ad_row"=>$row, "images"=>$images, "sale"=>$s, "useremail"=>$useremail));

			} catch (Exception $e) {
				mysqli_rollback($this->conn);
				echo $e->getMessage();				
			}

			mysqli_close($this->conn);
			//$this->view("oglasView", array("ad_row"=>$ad, "images"=>$images, "sale"=>$s));
		}

		function favouritePage() {
			$user = $this->model("User");
			$_SESSION['url'] = $_SERVER['REQUEST_URI'];

			mysqli_autocommit($this->conn, FALSE);

			$ad = $this->model("Add");
			$arr = $ad->getForFavouritesPage($this->conn);

			mysqli_commit($this->conn);
			mysqli_close($this->conn);
			$this->view("favoritiView", array("results"=>$arr));
		}

		function allow() {
			$user = $this->model("User");

			if (isset($_POST['submit'])) {

				mysqli_autocommit($this->conn, FALSE);

				try {

					$add = $this->model("Add");
					$add->allowAdd($this->conn, $_POST['id']);

					mysqli_commit($this->conn);

				} catch (Exception $e) {
					mysqli_rollback($this->conn);
					$_SESSION['msg'] = "Odobrenje oglasa nije uspelo!<br>Pokušajte ponovo.";
				}

				mysqli_close($this->conn);

				header("Location: admin.php");
				exit();
			}
			else {
				$user->checkPermNotLoggedIn(false);
			}
		}

		function reject() {

			$user = $this->model("User");

			if (isset($_POST['submit'])) {
				//validacija
				if (!isset($_POST['id']) || !isset($_POST['razlog']) || $_POST['razlog'] === '') {
					$_SESSION['msg'] = "Niste odredili razlog za odbijanje oglasa!<br>Pokušajte ponovo.";
					header("Location: admin.php");
					exit();
				}

				if (strlen($_POST['razlog']) > 50) {
					$_SESSION['msg'] = "Moguće je koristiti maksimalno 50 karaktera za razlog!<br>Pokušajte ponovo.";
					header("Location: admin.php");
					exit();
				}



				mysqli_autocommit($this->conn, FALSE);

				try {

					$add = $this->model("Add");
					$ret = $add->rejectAdd($this->conn, $_POST['id']);

					$vio = $this->model("Violation");
					$vio->createViolation($this->conn, $ret, $_POST['razlog'], isset($_POST['prestup']));

					$ret1 = $vio->getUserViolationNumber($this->conn, $ret["idKorisnika"]);
					$check = $user->checkMaxViolation($ret1);

					if ($check) {
						$user->removeUser($this->conn, $ret["idKorisnika"]);

						//vraca niz svih id-eva oglasa
						$id_arr = $add->deleteAllAdsFromUser($this->conn, $ret["idKorisnika"]);

						$image = $this->model("Image");
						$image->deleteAllImagesFromAdIdArray($this->conn, $id_arr);

						$sale = $this->model("Sale");
						$sale->deleteAllSalesFromAdIdArray($this->conn, $id_arr);

						$vio->removeAllViolationsUser($this->conn, $ret["idKorisnika"]);
					}

					mysqli_commit($this->conn);

				} catch (Exception $e) {
					$_SESSION['msg'] = $e->getMessage();
					mysqli_rollback($this->conn);
				}

				mysqli_close($this->conn);
				header("Location: admin.php");
				exit();
			}
			else {
				$user->checkPermNotLoggedIn(false);
			}
		}

		function delete() {

			$user = $this->model("User");

			if(isset($_POST['submit'])) {


				mysqli_autocommit($this->conn, FALSE);

				try {
					
					$add = $this->model("Add");
					$add->deleteAdd($this->conn, $_POST['id']);

					$violation = $this->model("Violation");
					$violation->removeViolation($this->conn, $_POST['id']);

					$image = $this->model("Image");
					$image->deleteAllImagesOfAd($this->conn, $_POST['id']);

					$sale = $this->model("Sale");
					$sale->deleteSale($this->conn, $_POST['id']);

					mysqli_commit($this->conn);
					$_SESSION['msg'] = "Uspešno ste obrisali oglas.";

				} catch (Exception $e) {
					mysqli_rollback($this->conn);
					$_SESSION['msg'] = "Brisanje oglasa nije uspelo!<br>Pokušajte ponovo.";

				} 

				mysqli_close($this->conn);
				header("Location: nalog.php");
				exit();
			} 
			else {
				$user->checkPermNotLoggedIn(false);
			}
		}

		function generateChangeAddPage() {
			$user = $this->model("User");
			if (isset($_POST['submit'])) {

				$add = $this->model("Add");
				$add_result = $add->getAdd($this->conn, $_POST['id']);

				$image = $this->model("Image");

				if (isset($_POST['idSlika'])) {	

					$tmp = $image->deleteImage($this->conn, $_POST['idSlika'], $_POST['id']);

					mysqli_close($this->conn);
					if ($tmp) $_SESSION['deleteMsg'] = "Uspešno ste obrisali sliku!";
					else  $_SESSION['deleteMsg'] = "Brisanje slike nije uspelo!<br>Pokušajte ponovo.";
				}

				$images_result = $image->getImages($this->conn, $_POST['id']);

				$sale = $this->model("Sale");
				$sale_result = $sale->getSale1($this->conn, $_POST['id']);

			}
			else {
				$user->checkPermNotLoggedIn(true);
			}
			$this->view("izmeniView", array("oglas" => $add_result, "slike" => $images_result, "popust" => $sale_result));
		}

		private $errorEmpty = false;
		private	$errorTitle = false;
		private	$errorSale = false;
		private	$errorSaleReason = false;
		private	$errorImages = false;

		function validateAd() {
			$check = true;
			if (empty($_POST['naziv']) || empty($_POST['lokacija']) || empty($_POST['street']) || empty($_POST['cenaDan']) || empty($_POST['cena']) || empty($_POST['kvadratura']) || empty($_POST['number']) || empty($_POST['telefon'])) {
				$this->errorEmpty = true;
				$check = false;
			}
			if (strlen($_POST['naziv']) > 128) {
				$this->errorTitle = true;
				$check = false;
			}
			if (isset($_POST['sale']) && (empty($_POST['discount']) || empty($_POST['reason']))) {
				$this->errorSale = true;
				$check = false;
			}
			if (isset($_POST['sale']) && strlen($_POST['reason']) > 50) {
				$this->errorSaleReason = true;
				$check = false;
			}
			return $check;
		}

		function new() {
			$user = $this->model("User");
			$user->checkPermUser();

			if (isset($_POST['submit'])) {

				if ($this->validateAd()) {
	

					mysqli_autocommit($this->conn, FALSE);

					try {

						$add = $this->model("Add");
						$idOglas = $add->newAdd($this->conn, $_POST['naziv'], $_POST['tip-nekretnine'], $_POST['lokacija'], $_POST['street'], $_POST['cenaDan'], $_POST['cena'], $_POST['kvadratura'], $_POST['number'], $_POST['namestenost'], $_POST['grejanje'], $_POST['ljubimci'], $_POST['telefon'], isset($_POST['cellar']), isset($_POST['phone']), isset($_POST['parking']), isset($_POST['air_condition']), isset($_POST['terrace']), isset($_POST['cable']), isset($_POST['internet']), isset($_POST['garage']), isset($_POST['lift']), isset($_POST['pool']), isset($_POST['alarm']), isset($_POST['yard']), isset($_POST['in_construction']), isset($_POST['recent']), $_POST['textarea']);

						$image = $this->model("Image");
						$image->uploadImages($this->conn, $_FILES, $idOglas);

						if (isset($_POST['sale'])) {
							$sale = $this->model("Sale");
							$sale->insertOrUpdateSale($this->conn, $_POST['discount'], $_POST['reason'], $idOglas);
						}

						mysqli_commit($this->conn);
						$_SESSION['novioglaslink'] = "./oglasi/$idOglas";
						$_SESSION['novioglasmsg'] = "Uspešno ste kreirali novi oglas!";					

					} catch (Exception $e) {
						mysqli_rollback($this->conn);
						if (strcmp($e->getMessage(), "Nedozvoljen broj slika") == 0) {
							$this->errorImages = true;
						}
						$_SESSION['msg'] .= "<br>Pokušajte ponovo.";
						$add->deleteDir("./oglasi/$idOglas");
					} 

					mysqli_close($this->conn);
					header("Location: novi.php");
					exit();
				}
			}
			$this->view("noviView", array("errorEmpty"=>$this->errorEmpty, "errorTitle"=>$this->errorTitle, "errorSale"=>$this->errorSale, "errorSaleReason"=>$this->errorSaleReason, "errorImages"=>$this->errorImages));
		}

		function change() {
			$user = $this->model("User");

			if (isset($_POST['submit'])) {

				if ($this->validateAd()) {
	

					mysqli_autocommit($this->conn, FALSE);

					try {	

						$add = $this->model("Add");
						$add->changeAdd($this->conn, $_POST['idOglas'], $_POST['naziv'], $_POST['tip-nekretnine'], $_POST['lokacija'], $_POST['street'], $_POST['cenaDan'], $_POST['cena'], $_POST['kvadratura'], $_POST['number'], $_POST['namestenost'], $_POST['grejanje'], $_POST['ljubimci'], $_POST['telefon'], isset($_POST['cellar']), isset($_POST['phone']), isset($_POST['parking']), isset($_POST['air_condition']), isset($_POST['terrace']), isset($_POST['cable']), isset($_POST['internet']), isset($_POST['garage']), isset($_POST['lift']), isset($_POST['pool']), isset($_POST['alarm']), isset($_POST['yard']), isset($_POST['in_construction']), isset($_POST['recent']), $_POST['textarea']);

						$violation = $this->model("Violation");
						$violation->removeViolation($this->conn, $_POST['idOglas']);

						$image = $this->model("Image");
						$num_image = $image->getNumberImages($this->conn, $_POST['idOglas']);
						$image->uploadImages($this->conn, $_FILES, $_POST['idOglas'], $num_image);

						$sale = $this->model("Sale");
						$sale->changeSale($this->conn, isset($_POST['sale']), $_POST['discount'], $_POST['reason'], $_POST['idOglas']);

						mysqli_commit($this->conn);
						$_SESSION['msg'] = "Uspešno ste izmenili oglas.";					

					} catch (Exception $e) {
						mysqli_rollback($this->conn);
						$_SESSION['msg'] = "Izmena oglasa nije uspela!";
						if (strcmp($e->getMessage(), "Nedozvoljen broj slika") == 0) {
							$_SESSION['msg'] .= "<br>Dozvoljeno je maksimalno 9 slika!";
						}
						$_SESSION['msg'] .= "<br>Pokušajte ponovo.";
					} 

				} else  {
					$_SESSION['msg'] = "<b>Izmena oglasa nije uspela!</b>";
					if ($this->errorEmpty) $_SESSION['msg'] .= "<br>Niste popunili sva polja označena zvezdicom (*).";
					if ($this->errorTitle) $_SESSION['msg'] .= "<br>Naslov ima više od maksimalnih 128 karaktera.";
					if ($this->errorSale) $_SESSION['msg'] .= "<br>Popust je uključen, ali polja za iznos i/ili razlog nisu popunjena.";
					if ($this->errorSaleReason) $_SESSION['msg'] .= "<br>Razlog popusta ima više od maksimalnih 50 karaktera.";
					$_SESSION['msg'] .= "<br>Pokušajte ponovo.";
				}

				mysqli_close($this->conn);
				header("Location: nalog.php");
				exit();
			}
			else {
				$user->checkPermNotLoggedIn(false);
			}
		}

		function search() {			
			$user = $this->model("User");

			if (isset($_GET['submit'])) {

				if (isset($_GET['idOglas'])) $idOglas = $_GET['idOglas'];
				else $idOglas = "";
				if (isset($_GET['namestenost'])) $namestenost = $_GET['namestenost'];
				else $namestenost = "";
				if (isset($_GET['grejanje'])) $grejanje = $_GET['grejanje'];
				else $grejanje = "";
				if (isset($_GET['ljubimci'])) $ljubimci = $_GET['ljubimci'];
				else $ljubimci = "";
				if (isset($_GET['brsobaOd'])) $brsobaOd = $_GET['brsobaOd'];
				else $brsobaOd = "";
				if (isset($_GET['brsobaDo'])) $brsobaDo = $_GET['brsobaDo'];
				else $brsobaDo = "";
				if (isset($_GET['sortby'])) $sortby = $_GET['sortby'];
				else $sortby = "";

				$ad = $this->model("Add");
				$result = $ad->searchAd($this->conn, 1, $this->item_per_page, $idOglas, $_GET['tip-nekretnine'], $_GET['mesto'], $_GET['cenaOd'], $_GET['cenaDo'], $_GET['kvadraturaOd'], $_GET['kvadraturaDo'], $namestenost, $grejanje, $ljubimci, $brsobaOd, $brsobaDo, isset($_GET['cellar']), isset($_GET['phone']), isset($_GET['parking']), isset($_GET['air_condition']), isset($_GET['terrace']), isset($_GET['cable']), isset($_GET['internet']), isset($_GET['garage']), isset($_GET['lift']), isset($_GET['pool']), isset($_GET['alarm']), isset($_GET['yard']), isset($_GET['in_construction']), isset($_GET['recent']), isset($_GET['special']), $sortby);

				mysqli_close($this->conn);
			}
			else {
				header("Location: /psi/pretraga.php?mesto=&tip-nekretnine=&cenaOd=&cenaDo=&kvadraturaOd=&kvadraturaDo=&brsobaOd=&brsobaDo=&namestenost=&grejanje=&ljubimci=&idOglas=&submit=Pretra%C5%BEi");
				exit();
			}

			$this->view("pretragaView", array("result"=>$result['result'], "id"=>$idOglas, "type"=>$_GET['tip-nekretnine'], "location"=>$_GET['mesto'], "priceFrom"=>$_GET['cenaOd'], "priceTo"=>$_GET['cenaDo'], "areaFrom"=>$_GET['kvadraturaOd'], "areaTo"=>$_GET['kvadraturaDo'], "furnished"=>$namestenost, "heating"=>$grejanje, "pets"=>$ljubimci, "roomNumFrom"=>$brsobaOd, "roomNumTo"=>$brsobaDo, "cellar"=>isset($_GET['cellar']), "phone"=>isset($_GET['phone']), "parking"=>isset($_GET['parking']), "ac"=>isset($_GET['air_condition']), "terrace"=>isset($_GET['terrace']), "cable"=>isset($_GET['cable']), "internet"=>isset($_GET['internet']), "garage"=>isset($_GET['garage']), "lift"=>isset($_GET['lift']), "pool"=>isset($_GET['pool']), "alarm"=>isset($_GET['alarm']), "yard"=>isset($_GET['yard']), "in_construction"=>isset($_GET['in_construction']), "recent"=>isset($_GET['recent']), "special"=>isset($_GET['special']), "sortby"=>$sortby, "num"=>$result['num']));
		}

		function searchMore() {

			$page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

			if(!is_numeric($page_number)){
				header('HTTP/1.1 500 Invalid page number!');
				exit();
			}

			$ad = $this->model("Add");
			$result = $ad->searchAd($this->conn, $page_number, $this->item_per_page, $_GET['idOglas'], $_GET['tip-nekretnine'], $_GET['mesto'], $_GET['cenaOd'], $_GET['cenaDo'], $_GET['kvadraturaOd'], $_GET['kvadraturaDo'], $_GET['namestenost'], $_GET['grejanje'], $_GET['ljubimci'], $_GET['brsobaOd'], $_GET['brsobaDo'], !empty($_GET['cellar']), !empty($_GET['phone']), !empty($_GET['parking']), !empty($_GET['air_condition']), !empty($_GET['terrace']), !empty($_GET['cable']), !empty($_GET['internet']), !empty($_GET['garage']), !empty($_GET['lift']), !empty($_GET['pool']), !empty($_GET['alarm']), !empty($_GET['yard']), !empty($_GET['in_construction']), !empty($_GET['recent']), !empty($_GET['special']), $_GET['sortby']);

			mysqli_close($this->conn);

			$this->view("pretragaRezultatView", array("result"=>$result['result']));
		}

		function favourite() {
			
			$ad = $this->model("Add");
			$ad->addToFavourites($this->conn, $_GET['id']);
			mysqli_close($this->conn);

		}

		function removefavourite() {

			$ad = $this->model("Add");
			$ad->removeFromFavourites($this->conn, $_GET['id']);
			mysqli_close($this->conn);

		}
	}

?>