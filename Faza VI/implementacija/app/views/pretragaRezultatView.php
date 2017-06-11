<?php

	$result = $data['result'];

	while ($row = $result->fetch_assoc()) {
			if ($row['Slika'] == "") $slika = "logoblack.png";
			else $slika = $row['Slika'];
			if ($row['Iznos'] != null && $row['Iznos'] != "") $popust = true;
			else $popust = false;
?>
<!DOCTYPE html>
	<html>
	<body>
					<div class="add">
						<?php if ($popust) echo "<div class='popust'>".$row['Iznos']."% ".$row['Razlog']."</div>"; ?>
						<div class="add-favor-button-holder">
							<button class="favbutton" title="Dodaj u favorite!" onclick="putinfo(this, <?php echo $row['id']; ?>)">
								<img src="./images/staricon.svg" width="30px">
							</button>
						</div>
						<a href="/psi/oglasi/<?php echo $row['id'];?>"><div class="add-thumbnail-holder"><img src="/psi/oglasi/<?php echo $row['id'].'/slike/'. $slika;?>" class="add-thumnail-holder-img"></div></a><div class="add-info-holder">
							<div class="add-info-header">
								<a href="/psi/oglasi/<?php echo $row['id'];?>" class="add-link">
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
	</body>
	</html>

<?php
	}

?>