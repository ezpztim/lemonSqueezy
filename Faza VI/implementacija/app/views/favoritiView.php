<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - Moji favoriti</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/favoriti.css">
	<link rel="stylesheet" type="text/css" href="./css/pretraga.css">
</head>
<body id="body">
	<div id="info-bar">
		<div id="date" class="middle"><?php echo date("d.m.Y."); ?></div>
		<div id="button-holder">
			<a href="./favoriti.php" title="Moji favoriti"><button id="favoriti">Moji favoriti</button></a>			
			<span id="separator"></span>			
			<?php 
				if(isset($_SESSION['username'])) {
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
	<div id="logo-holder">
		<div style="position: relative; left: -50%; width: 100%; height: 100%;">
			<a href="./" title="Lemon squeezy"><img src="./images/logo.png" height="100%" width="auto"></a>
		</div>
	</div>
	<div id="backhome">
		<div id="home">&laquo; <a href="./">Glavna</a></div>
		<hr>
		<div id="home">&laquo; <a href="./pretraga.php">Pretraga</a></div>
	</div>
	<div id="wrapper">
		<div id="wrapper-bg"></div>
		<div id="wrapper-inner">
			<div style="text-align: left;">
<?php 

	if (count($data['results']) > 0) {

?>
	<div id="brder" style="border-top: 1px solid black"></div>
<?php
		$results = $data['results'];
		for ($i = 0; $i < count($results); $i++) { 
			$row = $results[$i]->fetch_assoc();
			if ($row['Slika'] == "") $slika = "logoblack.png";
			else $slika = $row['Slika'];
?>
					<div class="add">
						<div class="add-favor-button-holder">
							<button class="favbutton" title="Ukloni iz favorita!" onclick="removeFav(this, <?php echo $row['id']; ?>)">
								<img src="./images/ukloni.svg" width="30px">
							</button>
						</div>
						<a target="_blank" href="/psi/oglasi/<?php echo $row['id'];?>"><div class="add-thumbnail-holder"><img src="/psi/oglasi/<?php echo $row['id'].'/slike/'. $slika;?>" class="add-thumnail-holder-img"></div></a><div class="add-info-holder">
							<div class="add-info-header">
								<a target="_blank" href="/psi/oglasi/<?php echo $row['id'];?>" class="add-link">
									<span class="middle" style="margin-left: 10px; margin-right: 112px;">
										<?php echo $row['Naziv'];?>
									</span>
								</a>
								<div class="add-id-holder">
									<table class="middle" style="width: 100%">
										<tr><td>ID:</td><td style="text-align: right;"><?php echo $row['id'];?></td></tr>
									</table>
								</div>
							</div>
							<table class="add-info-table middle" cellspacing="0">
								<tr><td><b>Lokacija:</b></td><td><?php echo $row['Ulica'];?>, <?php echo $row['Mesto'];?></td></tr>
								<tr><td><b>Tip:</b></td><td><?php echo $row['Tip'];?></td></tr>
								<tr><td><b>Broj soba:</b></td><td><?php echo $row['BrSoba'];?></td></tr>
								<tr><td><b>Nameštenost:</b></td><td><?php echo $row['Namestenost'];?></td></tr>
								<tr><td><b>Grejanje:</b></td><td><?php echo $row['Grejanje'];?></td></tr>
								<tr><td><b>Datum objave:</b></td><td><?php echo date("d.m.Y.", strtotime($row['DatumObjave']));?></td></tr>
							</table>
							<div class="add-price-area">
								<div style="padding-top: 7px; padding-bottom: 7px; border-bottom: 1px solid black;"><?php echo number_format($row['CenaMesec'],0,","," ");?>din</div>
								<div style="padding-top: 7px;"><?php echo $row['Kvadratura'];?>m<sup style="font-size: 10px">2</sup></div>
							</div>
						</div>
					</div>

<?php

		}
	}
	else echo "<div style='margin-top: 150px;margin-bottom: 150px' align='center'>Niste dodali nijedan oglas u listu favorita.<br>Da bi ste dodali oglas u listu favorita potrebno je da pritisnete dugme 'Dodaj u favorite'.</div>"

?>
<div id="empty" style='display: none; margin-top: 150px;margin-bottom: 150px' align='center'>Niste dodali nijedan oglas u listu favorita.<br>Da bi ste dodali oglas u listu favorita potrebno je da pritisnete dugme 'Dodaj u favorite'.</div>
			</div>
		</div>
	</div>
	<?php require_once ("./footer.php"); ?>
<script type="text/javascript" src="scripts/jquery-1.9.0.min.js"></script>
</body>
<script type="text/javascript">
	function fade() {
		document.getElementById("infobox").remove();
	}
	function removeFav(o, id) {
		$.get( 'ukloni_favorit.php', {
			'id': id
		}, function(data){
			o.parentNode.parentNode.remove();
			var i = document.querySelectorAll('#wrapper-inner .add').length;
			if (i == 0) {
				document.getElementById("brder").style.display = "none";
				document.getElementById("empty").style.display = "block";
			}
			if(data.trim().length == 0) {
				document.getElementById("body").innerHTML += "<div id='infobox'>Uspešno ste uklonili oglas (id: "+ id +") iz liste favorita!</div>";
			} else {
				document.getElementById("body").innerHTML += "<div id='infobox'>"+data+"</div>";
			}

			setTimeout(fade, 3000);
	
		});
	}
</script>
</html>