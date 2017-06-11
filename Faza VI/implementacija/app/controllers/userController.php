<?php 
	
	require_once 'Controller.php';
	
	class UserController extends Controller {

		private $errorEmpty = false;
		private $errorDiffPass = false;

		private $conn;

		function __construct() {

			include("db_config.php");
			$this->conn = $conn;

		}

		function registerValidation() {
			$check = true;
			if (empty($_POST['name']) || empty($_POST['surname']) || empty($_POST['email']) || empty($_POST['password'])) { 
				$check = false;
				$this->errorEmpty = true;
			}
			if (strcmp($_POST['password'], $_POST['confpassword']) != 0) {
				$check = false;
				$this->errorDiffPass = true;
			}
			return $check;
		}

		function loginValidation() {
			$check = true;
			if(empty($_POST['username']) || empty($_POST['password'])){
				$check = false;
				$this->errorEmpty = true;
			}
			return $check;
		}

		function register() {
			$user = $this->model("User");
			$user->checkPermLoggedIn();

			$errorExist = false;
			$err = 0;

			if (isset($_POST['submit'])) {
				if ($this->registerValidation()) {

					mysqli_autocommit($this->conn, FALSE);

					try {

						$err = $user->createNewUser($this->conn, $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password']);
						if ($err == -1) $errorExist = true;

						mysqli_commit($this->conn);

					} catch (Exception $e) {
						mysqli_rollback($this->conn);
					} 

					mysqli_close($this->conn);

					if ($err == 0) {
						header("Location: login.php");
						exit();
					}
				}
				
			}
			$this->view("registracijaView", array("errorExist"=>$errorExist, "errorEmpty"=>$this->errorEmpty, "errorDiffPass"=>$this->errorDiffPass));
		}

		function login() {
			$user = $this->model("User");
			$user->checkPermLoggedIn();

			$login_error = false;

			if (isset($_POST['submit'])) {
				if ($this->loginValidation()) {

					mysqli_autocommit($this->conn, FALSE);

					try {

						$err = $user->userLogin($this->conn, $_POST['username'], $_POST['password'], isset($_POST['autologin']));
						if ($err == 0) $login_error = true;

						mysqli_commit($this->conn);

					} catch (Exception $e) {
						mysqli_rollback($this->conn);
					} 

					mysqli_close($this->conn);
				}
			}
			$this->view("loginView", array("errorEmpty"=>$this->errorEmpty, "login_error"=>$login_error));
		}

		function logout() {
			$user = $this->model("User");
			$user->userLogout($this->conn);
		}

		function generateAdminPage() {
			$user = $this->model("User");
			$user->checkPermAdmin();

			$add = $this->model("Add");
			$arr = $add->getForAdminPage($this->conn);

			mysqli_close($this->conn);

			$this->view("adminView", $arr);
		}

		function generateUserPage() {
			$user = $this->model("User");
			$user->checkPermUser();

			$add = $this->model("Add");
			$arr = $add->getForUserPage($this->conn);

			$vio = $this->model("Violation");
			$vio_num = $vio->getUserViolationNumber($this->conn, $_SESSION['userid']);

			mysqli_close($this->conn);

			$this->view("nalogView", array("result" => $arr, "brprestupa" => $vio_num));
		}

		function validateContact() {
			$check = true;
			if (!filter_var($_GET["from"], FILTER_VALIDATE_EMAIL)) {
				echo "Ne valja upisan e-mail!<br>"; 
				$check = false;
			}
			if (!filter_var($_GET["to"], FILTER_VALIDATE_EMAIL)) {
				echo "Ne menjajte kod!"; 
				$check = false;
			}
			return $check;
		}

		function contact() {
			$user = $this->model("User");
			if ($this->validateContact()) {
				$user->contactUser($_GET['to'], $_GET['from'], $_GET['name'], $_GET['phone'], $_GET['text'], $_GET['subject']);
			}
		}
	}

?>