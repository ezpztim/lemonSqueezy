<?php
if(isSet($cookie_name)) {
	if(isSet($_COOKIE[$cookie_name])) {
		
		$substrarr = explode(':', $_COOKIE[$cookie_name]);
		$selector = trim($substrarr[0]);
		$selector = substr($selector, 0, 12);
		$token = trim($substrarr[1]);
		$token = hash('sha256', $token);

		include("db_config.php");

		mysqli_autocommit($conn, false);

		$stmt = $conn->prepare("SELECT * FROM tokens WHERE selector = ?");
		$stmt->bind_param('s', $selector);
		if (!$stmt->execute()) {
			mysqli_rollback($conn);
			//prikazi neki error
			mysqli_close($conn);
			return;
		}
		$stmt->store_result();

		if ($stmt->num_rows > 0) {

			echo "Uspesno pronadjen selector<br>";

			$stmt->bind_result($id, $selector_db, $token_db, $userid);
			$stmt->fetch();

			if (hash_equals($token_db, $token)) {

				echo "Uspesno uporedjeni tokeni<br>";
				
				$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
				$stmt->bind_param('i', $userid);
				if (!$stmt->execute()) {
					mysqli_rollback($conn);
					//prikazi neki error
					mysqli_close($conn);
					return;
				}
				$stmt->store_result();

				if ($stmt->num_rows > 0) {

					echo "Uspesno pronadjen id usera preko userid<br>";

					$stmt->bind_result($id2, $name, $surname, $email_db, $password, $is_admin);
					$stmt->fetch();

					$_SESSION['userid'] = $userid;
					$_SESSION['username'] = $name;
					$_SESSION['usersurname'] = $surname;
					$_SESSION['useremail'] = $email;
					$_SESSION['userisadmin'] = $is_admin;
					
					$token = bin2hex(random_bytes(20));
					$selector = bin2hex(random_bytes(12));
					$tokenhash = hash('sha256', $token);
					$stmt = $conn->prepare("UPDATE tokens SET selector = ?, token = ? WHERE id = ?");
					$stmt->bind_param('ssi', $selector, $tokenhash, $id);
					if (!$stmt->execute()) {
						mysqli_rollback($conn);
						//prikazi neki error
						mysqli_close($conn);
						return;
					}
					setcookie ($cookie_name, "$selector:$token", time() + $cookie_time);
				}
			}		
		}
		mysqli_commit($conn);
		mysqli_close($conn);
	}
}
?>