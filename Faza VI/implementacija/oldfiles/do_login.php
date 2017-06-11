<?php
	if(!$do_login) exit;

	$email = $_POST['username'];
	$post_password = $_POST['password'];

	$post_autologin = $_POST['autologin'];

	$sql = "SELECT * FROM users WHERE email = ?";

	include("db_config.php");

	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
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
        		$stmt->execute();
    		}

			$login_ok = true;

			$_SESSION['userid'] = $id;
			$_SESSION['username'] = $name;
			$_SESSION['usersurname'] = $surname;
			$_SESSION['useremail'] = $email;
			$_SESSION['userisadmin'] = $is_admin;

			if($post_autologin == 1) {
				$token = bin2hex(random_bytes(20));
				$selector = bin2hex(random_bytes(12));
				$tokenhash = hash('sha256', $token);
				$sql1 = "INSERT INTO tokens (selector, token, userid) VALUES ('$selector', '$tokenhash', $id) ";
				$stmt = $conn->prepare($sql1);
				$stmt->bind_param('ssi', $selector, $tokenhash, $id);
				$stmt->execute();
				setcookie ($cookie_name, "$selector:$token", time() + $cookie_time);
			}

			if($_SESSION['username']) {
   				if ($is_admin == true) $url = "admin.php";
   				else $url = "nalog.php";   				

   				$stmt->free_result();
   				mysqli_close($conn);
   				header("Location: $url");
   				exit;
   			}
		} else $login_error = true;

	} else $login_error = true;

	mysqli_close($conn);
?>