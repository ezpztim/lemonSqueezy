<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<head>
		<title>Lemon Squeezy - Prijava na nalog</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="./scripts/login.js" type="text/javascript" async></script>
		<link rel="stylesheet" type="text/css" href="./css/login.css">
	</head>
	<body>
		<div id="backhome">
			<div id="home">&laquo; <a href="./" title="Nazad na glavnu stranicu">Glavna</a></div>
		</div>
		<div id="success" class="center" <?php if (isset($_SESSION['register_success'])) echo 'style="display: inline-block"'; ?>>
			<b>Uspešno ste kreirali nalog.<br>Da biste se prijavili ukucajte lozinku.</b>
		</div>
		<div id="login-container" class="center">
			<div id="login-container-2">
				<div id="infobox">
					<div style="color: red; <?php if ($data["errorEmpty"]) echo "display: block;" ?>" id="error">Molim vas popunite sva polja!</div>
					<?php if($data["login_error"]) echo '<div style="color:red;">Pogrešno ste uneli kredencijale.</div>'; ?>
				</div>
				<form name="login" method="post" action="login.php" onsubmit="return validate()" style="text-align: center;">
					<input id="name" type="email" name="username" placeholder="Korisnički e-mail" value="<?php if (isset($_SESSION['register_success'])) { echo $_SESSION['register_success']; unset($_SESSION['register_success']); }?>"><br><br>
					<input type="password" name="password" id="pass" placeholder="Lozinka"><br><br>
					<div class="checkbox-holder">
						<table style="font-size: 12px; width: 80%">
							<tr>
								<td>Prikaži lozinku</td>
								<td >
									<div class="checkBoxSlider">   
										<input type="checkbox" value="None" id="showhide" onclick="toggle_password(event,'pass');"/>
										<label for="showhide" id="click"></label>
									</div>
								</td>
							</tr>
							<tr>
								<td>Zapamti me</td>
								<td>
									<div class="checkBoxSlider">   
										<input type="checkbox" name="autologin" id="autologin" value="1"/>
										<label for="autologin" id="click1"></label>
									</div>
								</td>
							</tr>
						</table>
					</div><br>
					<input id="submit" type="submit" name="submit" value="Prijava">
				</form>
				<div id="registrac">Nemate nalog? <a href="./registracija.php">Registrujte</a> se.</div>
			</div>
		</div>
	</body>
</HTML>