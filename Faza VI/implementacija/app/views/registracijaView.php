
<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - Novi nalog</title>
	<link rel="stylesheet" type="text/css" href="./css/registracija.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="./scripts/registration.js" type="text/javascript" async></script>
</head>
<body>
	<div id="backhome">
		<div id="home">&laquo; <a href="./" title="Nazad na glavnu stranicu">Glavna</a></div>
	</div>
	<div id="wrapper" class="center">
		<form onsubmit="return validate()" name="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >
			<h2 style="margin: 0;">Registracija</h2>
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<div style="<?php if ($data['errorEmpty']) echo "display: block;"; ?>color: red" id="error">Molim vas popunite sva polja označena sa *.</div>
				<div style="<?php if ($data['errorDiffPass']) echo "display: block;"; ?>color: red" id="error1">Unete lozinke se ne poklapaju.</div>
				<?php
					if ($data['errorExist'] == true) echo '<div style="color: red">Dati e-mail već ima svoj nalog. <a href="./login.php" style="color: red">Prijavite</a> se.</div>';
				?>
			</div>			
			<hr>
			<table style="text-align: left; margin: 0 auto;display: inline-block;">
				<tr>
					<td>Ime*:</td>
					<td><input name="name" id="formName" type="text" size="20" title="Ovde je potrebno uneti vaše ime" placeholder="Pera" autocomplete="off"></input></td>
				</tr>
				<tr>
					<td>Prezime*:&nbsp;</td>
					<td><input name="surname" id="formSurname" type="text" size="20" title="Ovde je potrebno uneti vaše prezime" placeholder="Perić" autocomplete="off"></input></td>
				</tr>
			</table>
			<hr>
			<table style="text-align: left; margin: 0 auto; display: inline-block;">
				<tr>
					<td>E-mail*:</td>
					<td><input type="email" name="email" id="formEmail" size="30" title="Ovde je potrebno uneti vaš e-mail" placeholder="bla@bla.rs" autocomplete="off"></input></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<span style="font-size: 12px;">Ovaj e-mail će se koristiti za prijavu na vaš nalog.</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td rowspan="2">Lozinka*:&nbsp;</td>
					<td><input type="password" name="password" id="formPassword" size="30" minlength="8" title="Ovde je potrebno uneti vašu odabranu lozinku" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off"></input></td>
				</tr>
				<tr>
					<td><input type="password" name="confpassword" id="formConfpassword" size="30" minlength="8" title="Ovde je potrebno pnoviti unetu lozinku" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" autocomplete="off"></input></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<span style="font-size: 12px">1) Lozinke u oba polja moraju da su jednake.&nbsp;&nbsp;</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: center;">
						<span style="font-size: 12px">2) Lozinka mora da sadrži minimalno 8 karaktera.</span>
					</td>
				</tr>
			</table>
			<hr>
			<input type="reset" title="Obriši sva polja" class="button" value="" onclick="remValidation()"></input>
			<input type="submit" name="submit" title="Izvrši pravljenje novog naloga" value="Napravi nalog" class="button" id="submit"></input>
		</form>
	</div>
</body>
</html>