<?php 

	class User {

		private $cookie_name = 'siteAuth';
		private $cookie_time = (3600 * 24 * 30);  // 30 dana

		private $conn;

		function __construct() {
			session_start();

			if (is_file("db_config.php")) include("db_config.php");
			else include ("../../db_config.php");
			$this->conn = $conn;

			if(!isset($_SESSION['username'])) $this->userAutoLogin();
			else $this->checkRemovedAccount();
		}

		function checkRemovedAccount() {
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
			$stmt->bind_param('i', $_SESSION['userid']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 0) $this->userLogout($this->conn);
		}

		function checkPermAdmin() {

			//require_once 'config.php';

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
		}

		function checkPermUser() {

			if(!isSet($_SESSION['username'])) {
				$_SESSION['url'] = $_SERVER['REQUEST_URI'];
				header("Location: login.php");
				exit;
			}
			else if ($_SESSION['userisadmin'] == 1) {
				if(isset($_SESSION['url'])) 
					$url = $_SESSION['url'];
				else {
					$url = "admin.php";
				}
				$_SESSION['url'] = $_SERVER['REQUEST_URI'];
				header("Location: $url");
				exit;
			}
			$_SESSION['url'] = $_SERVER['REQUEST_URI'];
		}

		function checkPermLoggedIn() {

			//require_once 'config.php';

			if(isset($_SESSION['username'])) {
				if(isset($_SESSION['url'])) 
					$url = $_SESSION['url'];
				else {
					if ($_SESSION['userisadmin'] == true) $url = "admin.php";
					else $url = "nalog.php";
				}

				header("Location: $url");
				exit;
			}
		}

		function checkPermNotLoggedIn($remember) {

			if(!isSet($_SESSION['username'])) {
				if ($remember) $_SESSION['url'] = $_SERVER['REQUEST_URI'];
				header("Location: login.php");
				exit;
			}
			else {
				if(isset($_SESSION['url'])) 
					$url = $_SESSION['url'];
				else {
					$url = "./";
				}
				if ($remember) $_SESSION['url'] = $_SERVER['REQUEST_URI'];
				header("Location: $url");
				exit;
			}
		}

		function checkMaxViolation($br) {
			if ($br >= 3) return true;
			else return false;
		}

		function createNewUser($conn, $name, $surname, $email, $password) {

			$password = password_hash(base64_encode(hash('sha384', $_POST['password'], true)), PASSWORD_DEFAULT);

			$sql1 = "SELECT email FROM users WHERE email = ?";
			$sql2 = "INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)";

			$stmt = $conn->prepare($sql1);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 0) {
				$stmt = $conn->prepare($sql2);
				$stmt->bind_param('ssss', $name, $surname, $email, $password);

				if (!$stmt->execute()) throw new Exception("");

				$_SESSION['register_success'] = $email;
				return 0;
			}
			else return -1;
		}

		function removeUser($conn, $id) {
			$sql1 = "DELETE FROM users WHERE id = ?";
			$sql2 = "DELETE FROM tokens WHERE userid = ?";

			$stmt = $conn->prepare($sql1);
			$stmt->bind_param('i', $id);
			if(!$stmt->execute()) throw new Exception("Uklanjanje korisnika nakon 3 velika prestupa nije uspelo.");

			$stmt = $conn->prepare($sql2);
			$stmt->bind_param('i', $id);
			if(!$stmt->execute()) throw new Exception("Uklanjanje korisnika nakon 3 velika prestupa nije uspelo.");

			$_SESSION['msg'] .= "<br><b>Uspešno je obrisan korisnik zbog 3 prestupa!</b>";
		}

		function getEmail($conn, $id) {
			$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
			$stmt->bind_param('i', $id);
			if (!$stmt->execute()) throw new Exception("Nije uspelo dohvatanje e-mail-a korisnika.");
			$stmt->store_result();
			$stmt->bind_result($email);
			$stmt->fetch();
			return $email;
		}

		function userLogin($conn, $email, $post_password, $post_autologin) {

			$sql = "SELECT * FROM users WHERE email = ?";			

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('s', $email);
			if (!$stmt->execute()) throw new Exception("");
			$stmt->store_result();

			if ($stmt->num_rows > 0) {

				$stmt->bind_result($id, $name, $surname, $email_db, $password, $is_admin);
				$stmt->fetch();

				if (password_verify(base64_encode(hash('sha384', $post_password, true)), $password)) {

					if (password_needs_rehash($row['password'], PASSWORD_DEFAULT)) {
						$tmp = password_hash(base64_encode(hash('sha384', $post_password, true)), PASSWORD_DEFAULT);
						$sql = "UPDATE users SET password = ? WHERE email = ?";
						$stmt = $conn->prepare($sql);
						$stmt->bind_param('ss', $tmp, $email);
						if (!$stmt->execute()) throw new Exception("");
					}

					$_SESSION['userid'] = $id;
					$_SESSION['username'] = $name;
					$_SESSION['usersurname'] = $surname;
					$_SESSION['useremail'] = $email;
					$_SESSION['userisadmin'] = $is_admin;

					if($post_autologin == 1) {
						$token = bin2hex(random_bytes(20));
						$selector = bin2hex(random_bytes(12));
						$tokenhash = hash('sha256', $token);
						$sql1 = "INSERT INTO tokens (selector, token, userid) VALUES (?, ?, ?)";
						$stmt = $conn->prepare($sql1);
						$stmt->bind_param('ssi', $selector, $tokenhash, $id);
						if (!$stmt->execute()) throw new Exception("");
						$_SESSION['usertokenid'] = $stmt->insert_id;
						setcookie ($this->cookie_name, "$selector:$token", time() + $this->cookie_time);
					}

					if($_SESSION['username']) {
						if ($is_admin == true) $url = "admin.php";
						else $url = "nalog.php";   				

						$stmt->free_result();
						mysqli_commit($conn);
						mysqli_close($conn);
						header("Location: $url");
						exit();
					}
				}
			} 
			return 0;
		}

		function userLogout($conn) {
			//require_once 'config.php';

			if(isSet($_SESSION['username'])) {
				unset($_SESSION['userid']);
				unset($_SESSION['username']);
				unset($_SESSION['usersurname']);
				unset($_SESSION['useremail']);
				unset($_SESSION['userisadmin']);

				if(isSet($_COOKIE[$this->cookie_name])) {
					setcookie ($this->cookie_name, '', time() - $this->cookie_time);
					if (isset($_SESSION['usertokenid'])) {
						$stmt = $conn->prepare("DELETE FROM tokens WHERE id = ?");
						$stmt->bind_param("i", $_SESSION['usertokenid']);
						$stmt->execute();					
					}
				}

				header("Location: ./");
				exit;
			}
			else {
				if(isset($_SESSION['url'])) 
					$url = $_SESSION['url'];
				else {
					$url = "./";
				}

				header("Location: $url");
				exit;
			}
		}

		function userAutoLogin() {
			if(isSet($this->cookie_name)) {
				if(isSet($_COOKIE[$this->cookie_name])) {

					$substrarr = explode(':', $_COOKIE[$this->cookie_name]);
					$selector = trim($substrarr[0]);
					$selector = substr($selector, 0, 12);
					$token = trim($substrarr[1]);
					$token = hash('sha256', $token);

					mysqli_autocommit($this->conn, false);

					$stmt = $this->conn->prepare("SELECT * FROM tokens WHERE selector = ?");
					$stmt->bind_param('s', $selector);
					if (!$stmt->execute()) {
						mysqli_rollback($this->conn);
						mysqli_close($this->conn);
						return;
					}
					$stmt->store_result();

					if ($stmt->num_rows > 0) {

						$stmt->bind_result($id, $selector_db, $token_db, $userid);
						$stmt->fetch();

						if (hash_equals($token_db, $token)) {

							$stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
							$stmt->bind_param('i', $userid);
							if (!$stmt->execute()) {
								mysqli_rollback($this->conn);
								mysqli_close($this->conn);
								return;
							}
							$stmt->store_result();

							if ($stmt->num_rows > 0) {

								$stmt->bind_result($id2, $name, $surname, $email_db, $password, $is_admin);
								$stmt->fetch();

								$_SESSION['userid'] = $userid;
								$_SESSION['username'] = $name;
								$_SESSION['usersurname'] = $surname;
								$_SESSION['useremail'] = $email_db;
								$_SESSION['userisadmin'] = $is_admin;
								$_SESSION['usertokenid'] = $id;

								$token = bin2hex(random_bytes(20));
								$selector = bin2hex(random_bytes(12));
								$tokenhash = hash('sha256', $token);
								$stmt = $this->conn->prepare("UPDATE tokens SET selector = ?, token = ? WHERE id = ?");
								$stmt->bind_param('ssi', $selector, $tokenhash, $id);
								if (!$stmt->execute()) {
									mysqli_rollback($this->conn);
									mysqli_close($this->conn);
									return;
								}
								setcookie ($this->cookie_name, "$selector:$token", time() + $this->cookie_time);
							}
						}		
					}
					mysqli_commit($this->conn);
					mysqli_close($this->conn);
				}
			}
		}

		function contactUser($to1, $from, $name, $phone, $text, $subject) {
			$to = "aleksa.funduk@gmail.com";

			include "./PHPMailer-master/PHPMailerAutoload.php";

			$mail = new PHPMailer(true);

			$mail->IsSMTP(); 
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = "tls"; 
			$mail->Host = "smtp.gmail.com"; 
			$mail->Port = 587; 
			$mail->Username = "ezpztim@gmail.com"; 
			$mail->Password = "ezpz1995"; 
			$mail->IsHTML(true); 

			$mail->AddAddress($to, "");
			$mail->SetFrom("ezpztim@gmail.com", "Lemon squeezy nekretnine");
			$mail->Subject = $subject;
			$mail->Body = "<b>Kontakt info:</b><br> - Ime: $name<br> - Telefon: $phone<br> - E-mail: $from<br>".$text;

			try{
				$mail->Send();

			} catch (phpmailerException $e) {
			    echo $e->errorMessage(); //Pretty error messages from PHPMailer
			} catch (Exception $e) {
			    echo $e->getMessage(); //Boring error messages from anything else!
			}
		}
	}

?>