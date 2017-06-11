<?php 

	$result = $data['result'];
	$result1 = $data['result1'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - izdavanje nekretnina</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/homepage.css">
</head>
<body>
	<div id="bg1" class="bg">
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
		<div id="logo-holder">
			<div style="position: relative; left: -50%; width: 100%; height: 100%;">
				<a href="./" title="Lemon squeezy"><img src="./images/logo.png" height="100%" width="auto"></a>
			</div>
		</div>
		<div id="search-bar">
			<div style="width: 100%; text-align: center;" class="middle">
				<form method="GET" action="pretraga.php" name="search" style="display: inline-block;">
					<span class="form-space"><h2>Pretraga</h2></span>
					<span class="form-data">
						<label>Lokacija:</label>
						<input name="mesto" type="text" placeholder="npr. Beograd, Novi Sad..." size="20"></input>
					</span>&nbsp;
					<span class="form-data">
						<label>Tip:</label>
						<select name="tip-nekretnine" style="width: 150px">
							<option value="" >Sve</option>
							<option value="Stambeni objekat">Stambeni objekat</option>
							<option value="Poslovni objekat">Poslovni objekat</option>
							<option value="Zemljište">Zemljište</option>
							<option value="Skladište">Skladište</option>
						</select>
					</span>&nbsp;
					<span class="form-data">
						<label>Cena (din):</label>
						<input name="cenaOd" type="number" placeholder="Od" min="1"></input>
						<input name="cenaDo" type="number" placeholder="Do" min="1"></input>
					</span>&nbsp;
					<span class="form-data">
						<label>Kvadratura:</label>
						<input name="kvadraturaOd" type="number" placeholder="Od" min="1"></input>
						<input name="kvadraturaDo" type="number" placeholder="Do" min="1"></input>
					</span>&nbsp;
					<span class="form-data">
						<input name="submit" type="submit" value="Pretraži" class="button" title="Izvrši pretragu" style="vertical-align: middle"></input>
					</span>
					<span class="form-data">
						<a href="./pretraga.php">Detaljna pretraga</a>
					</span>
				</form>	
			</div>
		</div>
	</div>
	<div id="bg2" class="bg">
		<div style="height: 50%; position: relative;">
			<div id="new-adds" class="center">
				<div><h2>Novi oglasi</h2></div>
				<div class="add-holder">
<?php
	$i = 1;
	$br = $result->num_rows;
	while ($row = $result->fetch_assoc()) {
?>
		<a href="./oglasi/<?php echo $row['id'];?>" class="add" title="Oglas: <?php echo $row['Naziv'];?>" <?php if ($i == 4) echo 'style="margin-right: 0;"'; ?>>
			<div style="height:calc(100% - 59px);position: relative; overflow: hidden">
				<img src="./oglasi/<?php echo $row['id'];?>/slike/<?php if ($row['Slika'] != '') echo $row['Slika']; else echo 'logoblack.png';?>" class="center">
			</div>
			<div style="position: relative;">
				<div class="triangle"></div>
				<div class="add-title"><?php echo $row['Naziv'];?></div><br>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left"><?php echo date("d.m.Y.", strtotime($row['DatumObjave']));?></td>
						<td style="text-align: right"><?php echo number_format($row['CenaMesec'],0,","," ");?>din</td>
					</tr>
					<tr>
						<td style="text-align: left"><?php echo $row['Tip'];?></td>
						<td style="text-align: right"><?php echo $row['Kvadratura'];?>m<sup>2</sup></td>
					</tr>
				</table>
			</div>
		</a>
<?php
		$i++;
	}
	for ($j = $br + 1; $j < 5; $j++) {
		if ($j < 4) echo "<div class='add'><span class='add-filler'>Oglas #$j</span></div>";
		else echo "<div class='add' style='margin-right: 0;'><span class='add-filler'>Oglas #$j</span></div>";
	}
?>
				</div>
				<a href="./pretraga.php" style="display: inline-block">
					<button style="width: 200px" class="button" title="Prikaži više novih oglasa">Još</button>
				</a>
			</div>
		</div>
		<div style="height: 50%; position: relative;">
			<div id="special-adds" class="center">
				<div><h2>Specijalne ponude</h2></div>
				<div class="add-holder">
<?php
	$i = 1;
	$br = $result1->num_rows;
	while ($row = $result1->fetch_assoc()) {
?>
		<a href="./oglasi/<?php echo $row['id'];?>" class="add" title="Oglas: <?php echo $row['Naziv'];?>" <?php if ($i == 4) echo 'style="margin-right: 0;"'; ?>>
			<div class="popust"><?php echo $row['Iznos']."% ". $row['Razlog'];?></div>
			<div style="height:calc(100% - 59px);position: relative; overflow: hidden">
				<img src="./oglasi/<?php echo $row['id'];?>/slike/<?php if ($row['Slika'] != '') echo $row['Slika']; else echo 'logoblack.png';?>" class="center">
			</div>
			<div style="position: relative;">
				<div class="triangle"></div>
				<div class="add-title"><?php echo $row['Naziv'];?></div><br>
				<table style="width: 100%;">
					<tr>
						<td style="text-align: left"><?php echo date("d.m.Y.", strtotime($row['DatumObjave']));?></td>
						<td style="text-align: right"><?php echo number_format($row['CenaMesec'],0,","," ");?>din</td>
					</tr>
					<tr>
						<td style="text-align: left"><?php echo $row['Tip'];?></td>
						<td style="text-align: right"><?php echo $row['Kvadratura'];?>m<sup>2</sup></td>
					</tr>
				</table>
			</div>
		</a>
<?php
		$i++;
	}
	for ($j = $br + 1; $j < 5; $j++) {
		if ($j < 4) echo "<div class='add'><span class='add-filler'>Oglas #$j</span></div>";
		else echo "<div class='add' style='margin-right: 0;'><span class='add-filler'>Oglas #$j</span></div>";
	}
?>
				</div>
				<a href="./pretraga.php?mesto=&tip-nekretnine=&cenaOd=&cenaDo=&kvadraturaOd=&kvadraturaDo=&submit=Pretraži&special=1" style="display: inline-block">
					<button style="width: 200px" class="button" title="Prikaži više oglasa iz specijalne ponude">Još</button>
				</a>
			</div>
		</div>
		
		<hr class="center" style="width: 96%; margin-top: 0">
		
	</div>
	<?php require_once "footer.php"; ?>
</body>
</html>