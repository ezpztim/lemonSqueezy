<?php 

	$row = $data['ad_row'];

	$slike = $data['images'];
	$brslika = $slike->num_rows;

	$s = $data['sale'];
	$sale = $s->num_rows;
	$s = $s->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - <?php echo $row['Naziv']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../css/oglas.css">
</head>
<body id="body">
	<div id="logo-holder">
		<div style="position: relative; left: -50%; width: 100%; height: 100%;">
			<a href="../../"><img src="../../images/logo.png" height="100%" width="auto" title="Logo"></a>
		</div>
	</div>
	<div id="backhome">
		<div id="home">&laquo; <a href="../../">Glavna</a></div><hr>
		<div id="home">&laquo; <a href="../../pretraga.php">Pretraga</a></div>
	</div>
	<div id="info-bar">
		<div id="date" class="middle"><?php echo date("d.m.Y."); ?></div>
		<div id="button-holder" class="middle">
			<a href="../../favoriti.php" title="Moji favoriti"><button id="favoriti">Moji favoriti</button></a>			
			<span id="separator"></span>
			<?php 
			if (isset($_SESSION['username'])) {
				if ($_SESSION['userisadmin'] == 0) echo '<a href="../../nalog.php" title="Moj nalog"><button class="button">Moj nalog</button></a>&nbsp;';
				else echo '<a href="../../admin.php" title="Moj nalog"><button class="button">Moj nalog</button></a>&nbsp;';
				echo '<a href="../../logout.php" title="Odjava sa mog naloga"><button class="button">Odjava</button></a>';
			}
			else {
				echo '<a href="../../login.php" title="Prijava na nalog"><button class="button">Prijava</button></a>&nbsp;';
				echo '<a href="../../registracija.php" title="Kreiranje novog naloga"><button class="button">Napravi nalog</button></a>';
			}			
			?>				
		</div>
	</div>

	<div id="wrapper">
		<div id="wrapper-bg"></div>
		<div id="wrapper-inner">
			<h2 style="margin-top: 0"><?php echo $row['Naziv']; ?></h2>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<div style="margin-left: 5%; margin-right: 5%; margin-top: 10px;">
				<div id="image-holder">
<?php
	for ($i = 0; $i < 9; $i++) {
		$j = $i + 1;
		if ($i%3 == 0) {
			echo "<div class='row'>";
			echo "<table>";
			echo "<tr style='height: 100%;'>";
		}
		if ($i < $brslika) {
			$sl = $slike->fetch_assoc();
			$slika = $sl['Ime'];
			echo "<td><a target='_blank' href='./slike/$slika'><img src='./slike/$slika'></a></td>";
		} else echo "<td><span class='center'>Slika$j</span></td>";
		if (($i+1)%3 == 0) {
			echo "</tr>";
			echo "</table>";
			echo "</div>";
		}
	}
?>					
				</div><div id="info-holder">
					<center>
						<table style="margin-left: 10px" cellspacing="0">
							<tr><td width="40%"><b>Mesto:</b></td><td width="60%"><?php echo $row['Mesto']; ?></td></tr>
							<tr><td><b>Ulica:</b></td><td><?php echo $row['Ulica']; ?></td></tr>
							<tr><td>&nbsp;</td><td></td></tr>
							<tr><td><b>Tip:</b></td><td><?php echo $row['Tip']; ?></td></tr>
							<tr><td><b>Kvadratura:</b></td><td><?php echo $row['Kvadratura']; ?>m<sup style="font-size: 10px">2</sup></td></tr>
							<tr><td><b>Broj soba:</b></td><td><?php echo $row['BrSoba']; ?></td></tr>
							<tr><td><b>Nameštenost:</b></td><td><?php echo $row['Namestenost']; ?></td></tr>
							<tr><td><b>Grejanje:</b></td><td><?php echo $row['Grejanje']; ?></td></tr>
							<tr><td><b>Ljubimci:</b></td><td><?php echo $row['Ljubimci']; ?></td></tr>
							<tr><td>&nbsp;</td><td></td></tr>
							<tr><td><b>Cena(dan):</b></td><td><?php echo $row['CenaMesec']; ?>din</td></tr>
							<tr><td><b>Cena(mesec):</b></td><td><?php echo $row['Cena1Dan']; ?>din</td></tr>
							<tr><td>&nbsp;</td><td></td></tr>
							<tr><td><b>Datum objave:</b></td><td><?php echo date("d.m.Y.", strtotime($row['DatumObjave'])); ?></td></tr>
						</table><br><br><br>
						<div class="special-table">
							<div class="special-row special-header"><b>Popust</b></div>
							<div class="special-row" style="border-bottom: 1px solid black"><?php if ($sale == 1) echo $s['Iznos']."%"; else echo "-";?></div>
							<div class="special-row"><?php if ($sale == 1) echo $s['Razlog']; else echo "-";?></div>
						</div><br>
						<div class="special-table">
							<div class="special-row special-header"><b>Kontakt telefon</b></div>
							<div class="special-row"><?php echo $row['KontaktTelefon'];?></div>
						</div><br><br>
						<button class="button" title="Dodaj u favorite" style="width: 80%" onclick="putinfo(this, <?php echo $row['id']; ?>)">Dodaj u favorite</button>
					</center>					
				</div>
			</div>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<div style="margin-left: 5%; margin-right: 5%;">
				<div><b>Opis</b></div><br>
				<span>
					<?php echo $row['Opis']; ?>
				</span>
			</div>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<div style="margin-left: 5%; margin-right: 5%;">
				<table style="text-align: left; margin: 0 auto;" >
					<tr>
						<td><label><input type="checkbox" name="cellar" <?php if ($row['Podrum']) echo "checked";?> disabled>Podrum</label></td>
						<td><label><input type="checkbox" name="phone" <?php if ($row['Telefon']) echo "checked";?> disabled>Telefon</label></td>
						<td><label><input type="checkbox" name="parking" <?php if ($row['Parking']) echo "checked";?> disabled>Parking</label></td>
						<td><label><input type="checkbox" name="air_condition" <?php if ($row['Klima']) echo "checked";?> disabled>Klima</label></td>
						<td><label><input type="checkbox" name="terrace" <?php if ($row['Terasa']) echo "checked";?> disabled>Terasa</label></td>
						<td><label><input type="checkbox" name="cable" <?php if ($row['Kablovska']) echo "checked";?> checked disabled>Kablovska</label></td>	
						<td><label><input type="checkbox" name="internet" <?php if ($row['Internet']) echo "checked";?> checked disabled>Internet</label></td>
					</tr>
					<tr>
						<td><label><input type="checkbox" name="garage" <?php if ($row['Garaza']) echo "checked";?> disabled>Garaža</label></td>
						<td><label><input type="checkbox" name="lift" <?php if ($row['Lift']) echo "checked";?> checked disabled>Lift</label></td>
						<td><label><input type="checkbox" name="pool" <?php if ($row['Bazen']) echo "checked";?> disabled>Bazen</label></td>
						<td><label><input type="checkbox" name="alarm" <?php if ($row['Alarm']) echo "checked";?> disabled>Alarm</label></td>	
						<td><label><input type="checkbox" name="yard" <?php if ($row['Dvoriste']) echo "checked";?> disabled>Dvorište</label> </td>
						<td><label><input type="checkbox" name="in_construction" <?php if ($row['Uizgradnji']) echo "checked";?> disabled>U izgradnji</label></td>
						<td><label><input type="checkbox" name="recent" <?php if ($row['Novogradnja']) echo "checked";?> disabled>Novogradnja</label></td>
					</tr>		
				</table>   
			</div>
			<hr style="margin-left: 5%;margin-right: 5%; margin-top: 10px; margin-bottom: 0"><br>
			<center>
				<form name="mail">
					<div><b>Kontakt e-mail</b></div><br>
					<input type="hidden" name="ad_email" value="<?php echo $data['useremail']; ?>">
					<input type="text" name="email_name" placeholder="Vaše ime" style="width: 250px" required><br><br>
					<input type="text" name="email_phone" placeholder="Telefon" style="width: 250px" required><br><br>
					<input type="text" name="email_email" placeholder="Vaš E-mail" style="width: 250px" required><br><br>
					<textarea name="email_comment" class="valid" cols="80" rows="15" style="resize: none">
Poštovani,

Kontaktiram Vas sa portala lemonsqueezy.co.nf povodom oglasa pod nazivom "<?php echo $row['Naziv']; ?>"...

Srdačan pozdrav, 
					</textarea><br><br>
					<div>
						<input class="button" type="reset" value=""></input>
						<input class="button" type="button" onclick="sendmail('<?php echo $row['Naziv']." (id: ".$row['id'].")"; ?>')" value="Pošalji" style="vertical-align: top; width: 200px;"></input>
					</div>
				</form>
			</center>

		</div>
	</div>
	<footer></footer>
	<script type="text/javascript" src="../../scripts/jquery-1.9.0.min.js"></script>
	<script type="text/javascript">
		function putinfo(o, id) {			
			$.get( '../../dodaj_favorit.php', {
				'id': id
			}, function(data){
				if(data.trim().length == 0) {
					document.getElementById("body").innerHTML += "<div id='infobox'>Uspešno ste dodali oglas (id: "+ id +") u listu favorita!</div>";
				} else {
					document.getElementById("body").innerHTML += "<div id='infobox'>"+data+"</div>";
				}

				setTimeout(fade, 3000);

			});
		}
		function sendmail(subject) {
			var email_to = document.forms['mail']['ad_email'];
			var validate = false;

			var email_from = document.forms['mail']['email_email'];
			if (email_from.value.length === 0) {
				email_from.style.borderBottom = '2px solid red';
				validate = true;
			}

			var email_from_name = document.forms['mail']['email_name'];
			if (email_from_name.value.length === 0) {
				email_from_name.style.borderBottom = '2px solid red';
				validate = true;
			}

			var email_from_phone = document.forms['mail']['email_phone'];
			if (email_from_phone.value.length === 0) {
				email_from_phone.style.borderBottom = '2px solid red';
				validate = true;
			}
			if (validate) { 
				alert("Molim vas popunite sva polja!");
				return;
			}

			var email_from_text = document.forms['mail']['email_comment'];
			
			$.get( '../../kontakt.php', {
				'to':email_to.value,
				'from':email_from.value,
				'name':email_from_name.value,
				'phone':email_from_phone.value,
				'text':email_from_text.value,
				'subject':subject
			}, function(data){
				if(data.trim().length == 0) {
					document.getElementById("body").innerHTML += "<div id='infobox'>Uspešno ste poslali mail!</div>";
				} else {
					document.getElementById("body").innerHTML += "<div id='infobox'>"+data+"</div>";
				}

				setTimeout(fade, 3000);

			});
		}
		function fade() {
			document.getElementById("infobox").remove();
		}
	</script>
</body>
</html>