<?php
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include("db_config.php");
$sql = "SELECT * FROM oglas WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($id, $title, $location, $street, $price_day, $price, $area, $type, $roomNumber, $furnished, $heating, $pets, $contact, $date, $description, $cellar, $parking, $garage, $ac, $terrace, $cable, $internet, $phone, $lift, $pool, $alarm, $yard, $inConstruction, $recent, $status, $userid);	

$stmt->fetch();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - <?php echo $title; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../css/oglas.css">
</head>
<body id="body">
	<div id="logo-holder">
		<div style="position: relative; left: -50%; width: 100%; height: 100%;">
			<a href="./"><img src="./images/logo.png" height="100%" width="auto" title="Logo"></a>
		</div>
	</div>
	<div id="backhome">
		<div id="home">&laquo; <a href="./">Glavna</a></div><hr>
		<div id="home">&laquo; <a href="./pretraga.php">Pretraga</a></div>
	</div>
	<div id="info-bar">
		<div id="date" class="middle"><?php echo date("d.m.Y."); ?></div>
		<div id="button-holder" class="middle">
			<a href="./favoriti.php" title="Moji favoriti"><button id="favoriti">Moji favoriti</button></a>			
			<span id="separator"></span>
			<?php 
			if (isset($_SESSION['username'])) {
				if ($_SESSION['userisadmin'] == 0) echo '<a href="./nalog.php" title="Moj nalog"><button class="button">Moj nalog</button></a>&nbsp;';
				else echo '<a href="./admin.php" title="Moj nalog"><button class="button">Moj nalog</button></a>&nbsp;';
				echo '<a href="./logout.php" title="Odjava sa mog naloga"><button class="button">Odjava</button></a>';
			}
			else {
				echo '<a href="./login.php" title="Prijava na nalog"><button class="button">Prijava</button></a>&nbsp;';
				echo '<a href="./registracija.php" title="Kreiranje novog naloga"><button class="button">Napravi nalog</button></a>';
			}			
			?>				
		</div>
	</div>

	<div id="wrapper">
		<div id="wrapper-bg"></div>
		<div id="wrapper-inner">
			<h2 style="margin-top: 0"><?php echo $title; ?></h2>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<div style="margin-left: 5%; margin-right: 5%; margin-top: 10px;">
				<div id="image-holder">
					<div class="row">
						<table>
							<tr style="height: 100%;">
								<td><img src="images/Desert.jpg"></td>
								<td><a target="_blank" href="images/belgrade.jpg"><img src="images/belgrade.jpg"></a></td>
								<td><span class="center">Slika3</span></td>
							</tr>
						</table>
					</div>
					<div class="row">
						<table>
							<tr style="height: 100%;">
								<td><img src="images/belgrade.jpg"></td>
								<td><span class="center">Slika5</span></td>
								<td><span class="center">Slika6</span></td>
							</tr>
						</table>
					</div>
					<div class="row">
						<table>
							<tr style="height: 100%;">
								<td><span class="center">Slika7</span></td>
								<td><span class="center">Slika8</span></td>
								<td><span class="center">Slika9</span></td>
							</tr>
						</table>
					</div>
				</div><div id="info-holder">
					<center>
						<table class="add-info-table" style="margin-left: 10px" cellspacing="0">
							<tr><td><b>Mesto:</b></td><td><?php echo $location; ?></td></tr>
							<tr><td><b>Ulica:</b></td><td><?php echo $street; ?></td></tr>
							<tr><td>&nbsp;</td><td></td></tr>
							<tr><td><b>Tip:</b></td><td><?php echo $type; ?></td></tr>
							<tr><td><b>Kvadratura:</b></td><td><?php echo $area; ?>m<sup style="font-size: 10px">2</sup></td></tr>
							<tr><td><b>Broj soba:</b></td><td><?php echo $roomNumber; ?></td></tr>
							<tr><td><b>Nameštenost:</b></td><td><?php echo $furnished; ?></td></tr>
							<tr><td><b>Grejanje:</b></td><td><?php echo $heating; ?></td></tr>
							<tr><td><b>Ljubimci:</b></td><td><?php echo $pets; ?></td></tr>
							<tr><td>&nbsp;</td><td></td></tr>
							<tr><td><b>Cena(dan):</b></td><td><?php echo $price_day; ?>din</td></tr>
							<tr><td><b>Cena(mesec):</b></td><td><?php echo $price; ?>din</td></tr>
							<tr><td>&nbsp;</td><td></td></tr>
							<tr><td><b>Datum objave:</b></td><td><?php echo date("d.m.Y.", strtotime($date)); ?></td></tr>
						</table><br><br><br>
						<div class="special-table">
							<div class="special-row special-header"><b>Popust</b></div>
							<div class="special-row" style="border-bottom: 1px solid black">10%</div>
							<div class="special-row">Popust za studente</div>
						</div><br>
						<div class="special-table">
							<div class="special-row special-header"><b>Kontakt telefon</b></div>
							<div class="special-row"><?php echo $contact;?></div>
						</div><br><br>
						<button class="button" title="Dodaj u favorite" style="width: 80%" onclick="putinfo(this)">Dodaj u favorite</button>
						<?php echo "Telefon: $phone";?>
					</center>					
				</div>
			</div>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<div style="margin-left: 5%; margin-right: 5%;">
				<div><b>Opis</b></div><br>
				<span>
					<?php echo $description; ?>
				</span>
			</div>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<div style="margin-left: 5%; margin-right: 5%;">
				<table style="text-align: left; margin: 0 auto;" >
					<tr>
						<td><label><input type="checkbox" name="cellar" <?php if ($cellar) echo "checked";?> disabled>Podrum</label></td>
						<td><label><input type="checkbox" name="phone" <?php if ($phone) echo "checked";?> disabled>Telefon</label></td>
						<td><label><input type="checkbox" name="parking" <?php if ($parking) echo "checked";?> disabled>Parking</label></td>
						<td><label><input type="checkbox" name="air_condition" <?php if ($ac) echo "checked";?> disabled>Klima</label></td>
						<td><label><input type="checkbox" name="terrace" <?php if ($terrace) echo "checked";?> disabled>Terasa</label></td>
						<td><label><input type="checkbox" name="cable" <?php if ($cable) echo "checked";?> checked disabled>Kablovska</label></td>	
						<td><label><input type="checkbox" name="internet" <?php if ($internet) echo "checked";?> checked disabled>Internet</label></td>
					</tr>
					<tr>
						<td><label><input type="checkbox" name="garage" <?php if ($garage) echo "checked";?> disabled>Garaža</label></td>
						<td><label><input type="checkbox" name="lift" <?php if ($lift) echo "checked";?> checked disabled>Lift</label></td>
						<td><label><input type="checkbox" name="pool" <?php if ($pool) echo "checked";?> disabled>Bazen</label></td>
						<td><label><input type="checkbox" name="alarm" <?php if ($alarm) echo "checked";?> disabled>Alarm</label></td>	
						<td><label><input type="checkbox" name="yard" <?php if ($yard) echo "checked";?> disabled>Dvorište</label> </td>
						<td><label><input type="checkbox" name="in_construction" <?php if ($inConstruction) echo "checked";?> disabled>U izgradnji</label></td>
						<td><label><input type="checkbox" name="recent" <?php if ($recent) echo "checked";?> disabled>Novogradnja</label></td>
					</tr>		
				</table>   
			</div>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<center>
				<form method="post">
					<div><b>Kontakt e-mail</b></div><br>
					<input type="text" name="emailOwner_name" placeholder="Vaše ime" style="width: 250px" required><br><br>
					<input type="text" name="emailOwner_phone" placeholder="Telefon" style="width: 250px" required><br><br>
					<input type="text" name="emailOwner_email" placeholder="Vaš E-mail" style="width: 250px" required><br><br>
					<textarea name="emailOwner_comment" class="valid" cols="80" rows="15" style="resize: none">
Poštovani,

Kontaktiram Vas sa portala lemonsqueezy.co.nf povodom oglasa pod nazivom "Stan sa pogledom na Vukov spomenik"...

Srdačan pozdrav, 
					</textarea><br><br>
					<div>
						<input class="button" type="reset" value=""></input>
						<input class="button" type="submit" value="Pošalji" style="vertical-align: top; width: 200px;"></input>
					</div>
				</form>
			</center>

		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		function putinfo(o) {
			document.getElementById("body").innerHTML += "<div id='infobox'>Uspešno ste dodali oglas u listu favorita!</div>"
			setTimeout(fade, 3000);
		}
		function fade() {
			document.getElementById("infobox").remove();
		}
	</script>
</body>
</html>