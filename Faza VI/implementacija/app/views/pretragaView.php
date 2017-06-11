<?php

	$result = $data['result'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - izdavanje nekretnina</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<div id="home">&laquo; <a href="./" title="Nazad na glavnu stranicu">Glavna</a></div>
	</div>
	<a href="#">
		<div id="backtop" title="Nazad na vrh stranice">
			<div id="backtopbutton">
				<div class="innerbutton">
					<div class="arrow"></div>
				</div>
			</div>
		</div>
	</a>
	<div id="wrapper">
		<span style="text-align: left;">
			<div id="wrapper-bg"></div>
			<div id="wrapper-left">
				<div id="results-header">
					<div class="middle" style="left: 3%; right: 5%;">
						<img src="images/searchicon.svg" width="20px" style="display: inline-block; vertical-align: middle;">&nbsp;&nbsp;&nbsp;
						<span style="vertical-align: middle;">Broj pronađenih oglasa: <b><?php echo $data['num']; ?></b>.</span>
						<span style="float:right;">
							<label>Sortiraj po:&nbsp;</label>
							<select id="selection" name="sortby" onchange="changeFunc()">
								<option value="0" <?php if($data['sortby'] != "" && $data['sortby'] == 'cenaOpadajuce'): ?> selected="selected"<?php endif; ?>>Ceni - opadajuće</option>
								<option value="1" <?php if($data['sortby'] != "" && $data['sortby'] == 'cenaRastuce'): ?> selected="selected"<?php endif; ?>>Ceni - rastuće</option>
								<option value="2" <?php if($data['sortby'] == "" || $data['sortby'] == 'datumOpadajuce'): ?> selected="selected"<?php endif; ?>>Datumu - novije</option>
								<option value="3" <?php if($data['sortby'] != "" && $data['sortby'] == 'datumRastuce'): ?> selected="selected"<?php endif; ?>>Datumu - starije</option>
								<option value="4" <?php if($data['sortby'] != "" && $data['sortby'] == 'kvadraturaOpadajuce'): ?> selected="selected"<?php endif; ?>>Kvadraturi - opadajuće</option>
								<option value="5" <?php if($data['sortby'] != "" && $data['sortby'] == 'kvadraturaRastuce'): ?> selected="selected"<?php endif; ?>>Kvadraturi - rastuće</option>
							</select>						
						</span>					
					</div>
				</div>
				<div id="add-holder">
<?php 

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		if ($row['Slika'] == "") $slika = "logoblack.png";
		else $slika = $row['Slika'];
		if ($row['Iznos'] != null && $row['Iznos'] != "") $popust = true;
		else $popust = false;
?>

					<div class="add">
						<?php if ($popust) echo "<div class='popust'>".$row['Iznos']."% ".$row['Razlog']."</div>"; ?>
						<div class="add-favor-button-holder">
							<button class="favbutton" title="Dodaj u favorite!" onclick="putinfo(this, <?php echo $row['id']; ?>)">
								<img src="./images/staricon.svg" width="30px">
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
} else echo "<div style='padding-top: 282px; padding-bottom: 282px; text-align:center'>Ne postoji nijedan oglas koji se uklapa u vasu pretragu!</div>";

?>
				</div>
<?php if ($result->num_rows > 0) { ?>
				<center>
					<button class="button" id="loadmore" style="width: 200px">Učitaj još</button>
				</center>
<?php } ?>
			</div>
			<div id="wrapper-right">
				<h2 style="margin: 0; margin-top: 10px;">Pretraga</h2><br>
				<hr style="margin-left: 5%;margin-right: 5%; margin-top: 0;">
				<form id="search" action="pretraga.php" method="get">
					<table style="width:88%; text-align: left; margin: 0 auto;">
						<tr>
							<td>Lokacija:</td>
							<td><input type="text" name="mesto" placeholder="npr. Beograd..." value="<?php echo htmlspecialchars($data['location']);?>" size="16"></input></td>
						</tr>
						<tr>
							<td>Tip:</td>
							<td>
								<select name="tip-nekretnine" style="width: 150px">
									<option value="" <?php if ($data['type'] == "") echo "selected";?>>Sve</option>
									<option value="Stambeni objekat" <?php if ($data['type'] == "Stambeni objekat") echo "selected";?>>Stambeni objekat</option>
									<option value="Poslovni objekat" <?php if ($data['type'] == "Poslovni objekat") echo "selected";?>>Poslovni objekat</option>
									<option value="Zemljište" <?php if ($data['type'] == "Zemljište") echo "selected";?>>Zemljište</option>
									<option value="Skladište" <?php if ($data['type'] == "Skladište") echo "selected";?>>Skladište</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Cena:</td>
							<td><input type="number" name="cenaOd" placeholder="Od" min="1" value="<?php echo htmlspecialchars($data['priceFrom']);?>" style="width: 68px"></input> <input type="number" name="cenaDo" placeholder="Do" min="1" value="<?php echo htmlspecialchars($data['priceTo']);?>" style="width: 68px"></input></td> 
						</tr>
						<tr>
							<td>Kvadratura:</td>
							<td><input type="number" name="kvadraturaOd" placeholder="Od" min="1" value="<?php echo htmlspecialchars($data['areaFrom']);?>" style="width: 68px"></input> <input type="number" name="kvadraturaDo" placeholder="Do" min="1" value="<?php echo htmlspecialchars($data['areaTo']);?>" style="width: 68px"></input></td> 
						</tr>
					</table>
					<hr style="margin-left: 5%;margin-right: 5%;">
					<table style="width:84%; text-align: left; margin: 0 auto;">
						<tr>
							<td>Broj soba:</td>
							<td><input type="number" name="brsobaOd" placeholder="Od" value="<?php echo htmlspecialchars($data['roomNumFrom']);?>" min="1"></input>&nbsp;<input type="number" name="brsobaDo" placeholder="Do" value="<?php echo htmlspecialchars($data['roomNumTo']);?>" min="1"></input></td> 
						</tr>
						<tr>
							<td>Nameštenost:</td>
							<td>
								<select name="namestenost" style="width: 120px">
									<option value="" <?php if ($data['furnished'] == "") echo "selected";?>>Sve</option>
									<option value="Namešten" <?php if ($data['furnished'] == "Namešten") echo "selected";?>>Namešten</option>
									<option value="Polunamešten" <?php if ($data['furnished'] == "Polunamešten") echo "selected";?>>Polunamešten</option>
									<option value="Nenamešten" <?php if ($data['furnished'] == "Nenamešten") echo "selected";?>>Nenamešten</option>
								</select>
							</td> 
						</tr>
						<tr>
							<td>Grejanje:</td>
							<td>
								<select name="grejanje" style="width: 120px">
									<option value="" <?php if ($data['heating'] == "") echo "selected";?>>Sve</option>
									<option value="Centralno" <?php if ($data['heating'] == "Centralno") echo "selected";?>>Centralno</option>
									<option value="Gas" <?php if ($data['heating'] == "Gas") echo "selected";?>>Gas</option>
									<option value="Električno" <?php if ($data['heating'] == "Električno") echo "selected";?>>Električno</option>
									<option value="Etažno" <?php if ($data['heating'] == "Etažno") echo "selected";?>>Etažno</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ljubimci:</td>
							<td>
								<select name="ljubimci" style="width: 120px">
									<option value="" <?php if ($data['pets'] == "") echo "selected";?>>Sve</option>
									<option value="Zabranjeni" <?php if ($data['pets'] == "Zabranjeni") echo "selected";?>>Zabranjeni</option>
									<option value="Dozvoljeni" <?php if ($data['pets'] == "Dozvoljeni") echo "selected";?>>Dozvoljeni</option>
								</select>
							</td>
						</tr>
					</table>
					<hr style="margin-left: 5%;margin-right: 5%;">
					<table style="width:82%; text-align: left; margin: 0 auto;" >
						<tr>
							<td><label><input type="checkbox" name="cellar" class="radio" value="1" <?php if ($data['cellar']) echo "checked";?>>Podrum</label></td>
							<td><label><input type="checkbox" name="phone" class="radio" value="1" <?php if ($data['phone']) echo "checked";?>>Telefon</label></td>
						</tr>
						<tr>
							<td><label><input type="checkbox" name="parking" class="radio" value="1" <?php if ($data['parking']) echo "checked";?>>Parking</label></td>
							<td><label><input type="checkbox" name="air_condition" class="radio" value="1" <?php if ($data['ac']) echo "checked";?>>Klima</label></td>

						</tr>
						<tr>
							<td><label><input type="checkbox" name="garage" class="radio" value="1" <?php if ($data['garage']) echo "checked";?>>Garaža</label></td>
							<td><label><input type="checkbox" name="lift" class="radio" value="1" <?php if ($data['lift']) echo "checked";?>>Lift</label></td>

						</tr>
						<tr>
							<td><label><input type="checkbox" name="pool" class="radio" value="1" <?php if ($data['pool']) echo "checked";?>>Bazen</label></td>
							<td><label><input type="checkbox" name="alarm" class="radio" value="1" <?php if ($data['alarm']) echo "checked";?>>Alarm</label></td>				
						</tr>
						<tr>
							<td><label><input type="checkbox" name="terrace" class="radio" value="1" <?php if ($data['terrace']) echo "checked";?>>Terasa</label></td>
							<td><label><input type="checkbox" name="cable" class="radio" value="1" <?php if ($data['cable']) echo "checked";?>>Kablovska</label></td>				
						</tr>
						<tr>
							<td><label><input type="checkbox" name="yard" class="radio" value="1" <?php if ($data['yard']) echo "checked";?>>Dvorište</label> </td>
							<td><label><input type="checkbox" name="in_construction" class="radio" value="1" <?php if ($data['in_construction']) echo "checked";?>>U izgradnji</label></td>

						</tr>
						<tr>
							<td><label><input type="checkbox" name="internet" class="radio" value="1" <?php if ($data['internet']) echo "checked";?>>Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
							<td><label><input type="checkbox" name="recent" class="radio" value="1" <?php if ($data['recent']) echo "checked";?>>Novogradnja</label></td>
						</tr>
					</table>   
					<hr style="margin-left: 5%;margin-right: 5%;">
					<label style="font-weight: bold;"><input type="checkbox" name="special" class="radio" value="1" <?php if ($data['special']) echo "checked";?>>Specijalne ponude</label>
					<hr style="margin-left: 5%;margin-right: 5%;">
					Šifra oglasa:&nbsp;<input type="number" name="idOglas" min="0" value="<?php echo htmlspecialchars($data['id']);?>" style="width:100px"></input>
					<hr style="margin-left: 5%;margin-right: 5%; margin-bottom: 20px;">
					<table style="width:50%;margin: 0 auto;">
						<tr>
							<td><input type="reset" value="" title="Obriši sva polja" class="button"></td>
							<td><input type="submit" name="submit" value="Pretraži"  title="Izvrši pretragu"  class="button" style="width: 200px"></input></td>
						</tr>
					</table>
				</form>
			</div>
		</span>
	</div>

	<?php require_once ("./footer.php"); ?>
<script type="text/javascript" src="scripts/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
	function changeFunc() {
		var selectedValue = selection.options[selection.selectedIndex].value;
		var arr = ["&sortby=cenaOpadajuce", "&sortby=cenaRastuce", "&sortby=datumOpadajuce", "&sortby=datumRastuce", "&sortby=kvadraturaOpadajuce", "&sortby=kvadraturaRastuce"];
		var link = window.location.href;
		for (var i = 0; i < arr.length; i++) {
			if (link.search(arr[i]) != -1) link = link.replace(arr[i], "");
		}
		window.location.href = link + arr[selectedValue];
	}
	function bla() {
		document.getElementById("loadmore").disabled = true;
		document.getElementById("loadmore").innerHTML = "Nema više oglasa..."
	}
	function putinfo(o, id) {
		//document.getElementById("infobox").style.display = "block";
		$.get( 'dodaj_favorit.php', {
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
	function fade() {
		document.getElementById("infobox").remove();
	}
	$(document).ready(function(){
		var track_page = 1; 
		$("#loadmore").click(function (e) { //user clicks on button
			track_page++; //page number increment everytime user clicks load button
			load_contents(track_page); //load content
		});
	});
	function getParameterByName(name, url) {
	    if (!url) url = window.location.href;
	    name = name.replace(/[\[\]]/g, "\\$&");
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}
	function load_contents(track_page){
		var mesto = getParameterByName("mesto");
		var tip = getParameterByName("tip-nekretnine");
		var cenaOd = getParameterByName("cenaOd");
		var cenaDo = getParameterByName("cenaDo");
		var kvadraturaOd = getParameterByName("kvadraturaOd");
		var kvadraturaDo = getParameterByName("kvadraturaDo");

		var brsobaOd, brsobaDo, namestenost, grejanje, ljubimci, idOglas;
		if ((brsobaOd = getParameterByName("brsobaOd")) == null) brsobaOd = "";
		if ((brsobaDo = getParameterByName("brsobaDo")) == null) brsobaDo = "";
		if ((namestenost = getParameterByName("namestenost")) == null) namestenost = "";
		if ((grejanje = getParameterByName("grejanje")) == null) grejanje = "";
		if ((ljubimci = getParameterByName("ljubimci")) == null) ljubimci = "";
		if ((idOglas = getParameterByName("idOglas")) == null) idOglas = "";

		var selectedValue = selection.options[selection.selectedIndex].value;
		var arr = ["cenaOpadajuce", "cenaRastuce", "datumOpadajuce", "datumRastuce", "kvadraturaOpadajuce", "kvadraturaRastuce"];
		selectedValue = arr[selectedValue];

		var cellar, phone, parking, ac, terrace, cable, internet, garage, lift, pool, alarm, yard, in_construction, recent, special;
		if ((cellar = getParameterByName("cellar")) == null) cellar = "";
		if ((phone = getParameterByName("phone")) == null) phone = "";
		if ((parking = getParameterByName("parking")) == null) parking = "";
		if ((ac = getParameterByName("air_condition")) == null) ac = "";
		if ((terrace = getParameterByName("terrace")) == null) terrace = "";
		if ((cable = getParameterByName("cable")) == null) cable = "";
		if ((internet = getParameterByName("internet")) == null) internet = "";
		if ((garage = getParameterByName("garage")) == null) garage = "";
		if ((lift = getParameterByName("lift")) == null) lift = "";
		if ((pool = getParameterByName("pool")) == null) pool = "";
		if ((alarm = getParameterByName("alarm")) == null) alarm = "";
		if ((yard = getParameterByName("yard")) == null) yard = "";
		if ((in_construction = getParameterByName("in_construction")) == null) in_construction = "";
		if ((recent = getParameterByName("recent")) == null) recent = "";

		if ((special = getParameterByName("special")) == null) special = "";
	
		$.get( 'fetch_results.php', {
			'page': track_page,
			'mesto': mesto,
			'tip-nekretnine': tip,
			'cenaOd': cenaOd,
			'cenaDo': cenaDo,
			'kvadraturaOd': kvadraturaOd,
			'kvadraturaDo': kvadraturaDo,
			'brsobaOd': brsobaOd,
			'brsobaDo': brsobaDo,
			'namestenost': namestenost,
			'grejanje': grejanje,
			'ljubimci': ljubimci,
			'idOglas': idOglas,
			'cellar': cellar,
			'phone': phone,
			'parking': parking,
			'air_condition': ac,
			'terrace': terrace,
			'cable': cable,
			'internet': internet,
			'garage': garage,
			'lift': lift,
			'pool': pool,
			'alarm': alarm,
			'yard': yard,
			'in_construction': in_construction,
			'recent': recent,
			'special': special,
			'sortby': selectedValue
		}, function(data){
	
			if(data.trim().length == 0){
				$("#loadmore").text("Nema više oglasa...").prop("disabled", true);
			}
	
			$("#add-holder").append(data);
	
		});
	}
</script>
</body>
</html>