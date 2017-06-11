
<!DOCTYPE html>
<html>
<head>
	<title>Lemon squeezy - Novi oglas</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/novi.css">
</head>
<body>
	<div id="nav">
		<div id="backhome" class="middle">
			<div id="home">&laquo; <a href="./" title="Nazad na glavnu stranicu">Glavna</a></div>
		</div>
		<div class="center"><h2>Novi oglas</h2></div>
		<div id="account-button-holder">
			<span style="vertical-align: middle;"><?php echo $_SESSION['username']." ".$_SESSION['usersurname'];?>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
			<a href="./nalog.php" title="Moj nalog"><button class="button">Moj nalog</button></a>
			<a href="./logout.php" title="Odjava sa mog naloga"><button class="button">Odjava</button></a>
		</div>
	</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="novi" enctype="multipart/form-data">
		<div id="wrapper">
			<div class="wrapper" id="err-holder" style="width: 839px; padding-bottom: 5px; padding-top: 5px; margin: 0 auto; margin-top: -10px; margin-bottom: 10px; color:  red; <?php if ($data['errorEmpty'] || $data['errorTitle'] || $data['errorSale'] || $data['errorSaleReason'] || $data['errorImages']) echo "display: block"; ?>">
				<div id="error" class="err" style="<?php if ($data['errorEmpty']) echo "display: block"; ?>">Molim vas popunite sva polja označena zvezdicom (*).</div>
				<div id="error1" class="err" style="<?php if ($data['errorTitle']) echo "display: block"; ?>">Naslov ima više od maksimalnih 128 karaktera.</div>
				<div id="error2" class="err" style="<?php if ($data['errorSale']) echo "display: block"; ?>">Popust je uključen, ali polja za iznos i/ili razlog nisu popunjena.</div>
				<div id="error3" class="err" style="<?php if ($data['errorSaleReason']) echo "display: block"; ?>">Razlog popusta ima više od maksimalnih 50 karaktera.</div>
				<div id="error4" class="err" style="<?php if ($data['errorImages']) echo "display: block"; ?>">Dozvoljeno je maksimalno 9 slika!</div>
				<div id="error5" class="err">Format broja soba je neodgovarajuć. (Mora npr. 3 ili 3.5)</div>
			</div>
			<div style="width: 488px; display: inline-block;">
				<div class="wrapper" style="padding-bottom: 4px; width: 468px;">
					<h3>Naziv i opis</h3>
					<button class="info infobutton button" title="Informacije i pravila" type="button" onclick="showinfo('naziviopis')"></button>
					<hr>
					<div id="naziviopis" style="font-size: 12px; display: none;">
						<div>1)Naziv može da ima maksimalno 128 karaktera.</div>
					</div>
					<table style="text-align: left; margin: 0 auto;display: inline-block;">
						<tr>
							<td>Naziv oglasa*:</td>
							<td><input id="naziv" type="text" size="47" name="naziv" placeholder="npr. Novi stan u Beogradu..." autocomplete="off" required></input></td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>Opis:</td>
							<td><textarea name="textarea" cols="48" rows="6"></textarea></td>
						</tr>
					</table>
				</div>
				<div class="wrapper" style="width: 468px; margin-top: 20px;">
					<h3>Cena i popust</h3>
					<button class="info infobutton button" title="Informacije i pravila" type="button" onclick="showinfo('cena')"></button>
					<hr>
					<div id="cena" style="font-size: 12px; display: none;">
						<div>1)Cene su izražene u dinarima.</div>
						<div>2)Popust nije obavezan.</div>
						<div>3)Ukoliko je uključen popust potrebno je dati razlog (maks. 50 karaktera)</div>
					</div>
					<div>
						Cena(dan)*:<input type="number" min="1" name="cenaDan" placeholder="npr. 1500" style="width: 120px;" required></input>
						Cena(mesec)*:<input type="number" min="1" name="cena" placeholder="npr. 30000" style="width: 120px;" required></input>
					</div><br>
					<div style="margin-bottom: 3px;">
						<label><input type="checkbox" name="sale" value="1">Popust</label>
						<input type="number" placeholder="Koliko?" name="discount" min="1" style="width: 60px"></input>
						<input type="text" placeholder="Razlog (npr. popust za studente...)" name="reason" size="38"></input>
					</div>				
				</div>
				<div class="wrapper" style="margin-top: 20px; width: 468px; padding-bottom: 3px;">
					<h3>Detalji</h3>
					<button class="info infobutton button" title="Informacije i pravila" type="button" onclick="showinfo('detalji')" disabled></button>
					<hr>
					<table style="text-align: left; margin: 0 auto;" >
						<tr>
							<td><label><input type="checkbox" name="cellar" class="radio" value="1">Podrum</label></td>
							<td><label><input type="checkbox" name="phone" class="radio" value="1">Telefon</label></td>
							<td><label><input type="checkbox" name="parking" class="radio" value="1">Parking</label></td>
							<td><label><input type="checkbox" name="air_condition" class="radio" value="1">Klima</label></td>
							<td><label><input type="checkbox" name="cable" class="radio" value="1">Kablovska</label></td>	
							<td><label><input type="checkbox" name="internet" class="radio" value="1">Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
						</tr>
						<tr>
							<td><label><input type="checkbox" name="terrace" class="radio" value="1">Terasa</label></td>
							<td><label><input type="checkbox" name="garage" class="radio" value="1">Garaža</label></td>
							<td><label><input type="checkbox" name="lift" class="radio" value="1">Lift</label></td>
							<td><label><input type="checkbox" name="pool" class="radio" value="1">Bazen</label></td>
							<td><label><input type="checkbox" name="alarm" class="radio" value="1">Alarm</label></td>	
							<td><label><input type="checkbox" name="yard" class="radio" value="1">Dvorište</label> </td>
						</tr>
					</table>
					<label><input type="checkbox" name="in_construction" class="radio" value="1">U izgradnji</label>
					<label><input type="checkbox" name="recent" class="radio" value="1">Novogradnja</label>
				</div>
			</div><div style="display: inline-block; width: 351px; margin-left: 20px; vertical-align: top">
				<div class="wrapper" style="width: 331px;">
					<h3>Opšte informacije</h3>
					<button class="info infobutton button" title="Informacije i pravila" type="button" onclick="showinfo('opste')"></button>
					<hr>
					<div id="opste" style="font-size: 12px; display: none;">
						<div>1)Ukoliko objekat sadrzi pola sobe dodajte .5 (npr 3.5).</div>
					</div>
					<table style="text-align: left; margin: 0 auto;display: inline-block;">
						<td>Tip*:</td>
						<td>
							<select name="tip-nekretnine" style="width: 150px">
								<option value="Stambeni objekat">Stambeni objekat</option>
								<option value="Poslovni objekat">Poslovni objekat</option>
								<option value="Zemljište">Zemljište</option>
								<option value="Skladište">Skladište</option>
							</select>
						</td>
						<tr>
							<td>Mesto*:</td>
							<td><input type="text" size="25"  placeholder="npr. Beograd, Novi Sad..." name="lokacija" required></input></td>
						</tr>
						<tr>
							<td>Ulica*:</td>
							<td><input type="text" size="25"  placeholder="npr. Vojvode Stepe 22" name="street" required></input></td>
						</tr>
						<tr>
							<td>Kvadratura(m<sup style="font-size: 10px">2</sup>)*:</td>
							<td><input type="number" min="1" name="kvadratura" placeholder="npr. 99" onkeypress="return isNumber(event)" required></input></td>
						</tr>
						<tr>
							<td>Broj soba*:</td>
							<td><input type="number" name="number" step="0.5" placeholder="npr. 3" min="1" required></input></td> 
						</tr>
						<tr>
							<td>Nameštenost*:</td>
							<td>
								<select name="namestenost" style="width: 120px">
									<option value="Namešten">Namešten</option>
									<option value="Polunamešten">Polunamešten</option>
									<option value="Nenamešten">Nenamešten</option>
								</select>
							</td> 
						</tr>
						<tr>
							<td>Grejanje*:</td>
							<td>
								<select name="grejanje" style="width: 120px">
									<option value="Centralno">Centralno</option>
									<option value="Gas">Gas</option>
									<option value="Električno">Električno</option>
									<option value="Etažno">Etažno</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ljubimci*:</td>
							<td>
								<select name="ljubimci" style="width: 120px">
									<option value="Zabranjeni">Zabranjeni</option>
									<option value="Dozvoljeni">Dozvoljeni</option>
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div class="wrapper" style="width: 331px; margin-top: 20px;">
					<h3>Telefon</h3>
					<button class="info infobutton button" title="Informacije i pravila" type="button" onclick="showinfo('telefon')"></button>
					<hr>
					<div id="telefon" style="font-size: 12px; display: none;">
						<div>1)Broj telefona treba da izgleda kao dat primer (062555333).</div>
					</div>
					<div>Mob. telefon*:<input type="text" name="telefon" placeholder="npr. 062555333" required></input></div>
				</div>
				<div class="wrapper" style="width: 331px; margin-top: 20px;">
					<h3>Slike</h3>
					<button class="info infobutton button" title="Informacije i pravila" type="button" onclick="showinfo('slike')"></button>
					<hr>
					<div id="slike" style="font-size: 12px; display: none;">
						<div>1)Nije obavezno kačenje slika.</div>
						<div>2)Moguće je okačiti maksimalno 9 slika.</div>
					</div>
					<table>
						<tr>
							<td style="text-align: center;">
								<div id="upload-container">
									<p id="text">Nema izabranih slika.</p>
									<div id="browse">
										<p>Nadji <img src="./images/foldericon.png" height="10"></p>
										<label for="upload"></label>
										<input id="upload" type="file" name="files[]" multiple="multiple" accept="image/*" onchange="filenumber()">
									</div>
									<div id="clear" onclick="clearfiles('upload')">
										<p>Obriši <img src="./images/trashcanicon.png" height="11"></p>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="wrapper" style="width: 839px; padding-bottom: 5px; padding-top: 5px; margin: 0 auto; display: block; margin-top: 20px;">
				<input type="reset" value="" class="button">			
				<button type="button" id="pritisni" onclick="openpopup(event)" class="button" style="width: 400px;">Postavi</button>
			</div>
		</div>
		<div id="cover" class="center" <?php if (isset($_SESSION['novioglasmsg'])) echo "style='display: block;'"; ?>></div>
		<div id="confirm" class="center">
			<div>Da li ste sigurni?</div><br>
			<div>
				<input type="submit" name="submit" value="Da" class="button" style="width: 100px;"></input>
				<button type="button" onclick="closepopup(event)" class="button" style="width: 100px;">Ne</button>
			</div>
		</div>
		<?php 
			if (isset($_SESSION['novioglasmsg'])) {
		?>
			<div id="end" class="center" style="display: block;">
				<div><?php echo $_SESSION['novioglasmsg']; ?></div><br>
				<div>
					<button type="button" onclick="closepopup(event)" class="button" style="<?php if (!isset($_SESSION['novioglaslink'])) echo "width: 100px";?>"><?php if (isset($_SESSION['novioglaslink'])) echo "Novi oglas"; else echo "Ok"; ?></button>
					<?php if (isset($_SESSION['novioglaslink'])) { ?>
					<a href="./nalog.php" class="button" style="text-decoration: none">Nazad na nalog</a>
					<a href="<?php echo htmlspecialchars($_SESSION['novioglaslink']); ?>" class="button" style="text-decoration: none">Pogledaj oglas</a>
					<?php } ?>
				</div>
			</div>
		<?php
				unset($_SESSION['novioglaslink']);
				unset($_SESSION['novioglasmsg']);
			}
		?>
	</form>
	<div id="copywright">&copy; <?php echo date("Y");?>. EZPZ tim. Sva prava zadržana.</div>
	<script type="text/javascript">
		function validate() {
			var provera = true;
			var x = document.forms["novi"]["naziv"];
			var y = document.forms["novi"]["cenaDan"];
			var z = document.forms["novi"]["cena"];
			var m = document.forms["novi"]["lokacija"];
			var n = document.forms["novi"]["street"];
			var o = document.forms["novi"]["kvadratura"];
			var p = document.forms["novi"]["number"];
			var q = document.forms["novi"]["telefon"];
			if (x.value == null || x.value == "") {
				x.style.borderBottom = '2px solid red';
				provera = false;
			}
			if ( y.value == null || y.value == "") {
				y.style.borderBottom = '2px solid red';
				provera = false;
			}
			if (z.value == null || z.value == "") {
				z.style.borderBottom = '2px solid red';
				provera = false;
			}
			if (m.value == null || m.value == "") {
				m.style.borderBottom = '2px solid red';
				provera = false;
			}
			if (n.value == null || n.value == "") {
				n.style.borderBottom = '2px solid red';
				provera = false;
			}
			if ( o.value == null || o.value == "") {
				o.style.borderBottom = '2px solid red';
				provera = false;
			}
			if (p.value == null || p.value == "") {
				p.style.borderBottom = '2px solid red';
				provera = false;
			}
			if ( q.value == null || q.value == "") {
				q.style.borderBottom = '2px solid red';
				provera = false;
			}
			if (!provera) { 
				document.getElementById("error").style.display = 'block';
				document.getElementById("err-holder").style.display = 'block';
			}
			return provera;
		}
		function validate1() {
			var provera = true;
			var x = document.forms["novi"]["naziv"];
			var y = document.forms["novi"]["discount"];
			var z = document.forms["novi"]["reason"];
			var q = document.forms["novi"]["sale"];
			if (x.value.length > 128) {
				x.style.borderBottom = '2px solid red';
				document.getElementById("error1").style.display = 'block';
				provera = false;
			}
			if(q.checked){
				if(y.value == "" || y.value == null) {
					y.style.borderBottom = '2px solid red';
					document.getElementById("error2").style.display = 'block';
					provera = false;
				}
				if(z.value == "" || z.value == null) {
					z.style.borderBottom = '2px solid red';
					document.getElementById("error2").style.display = 'block';
					provera = false;
				}
				if (z.value.length > 50) {
					z.style.borderBottom = '2px solid red';
					document.getElementById("error3").style.display = 'block';
					provera = false;
				}
			}
			if (!provera) { 
				document.getElementById("err-holder").style.display = 'block';
			}
			return provera;
		}
		function validate2() {
			if (! /^\d+(\.5)?$/.test(document.forms["novi"]["number"].value)) {
				document.forms["novi"]["number"].style.borderBottom = '2px solid red';
				document.getElementById("err-holder").style.display = 'block';
				document.getElementById("error5").style.display = 'block';
				scrollToTop(300);
				return false;
			}
			return true;
		}
		function checkEnter(e){
			e = e || event;
			var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
			return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
		}
		document.querySelector('form').onkeypress = checkEnter;
		function showinfo(id) {
			if (document.getElementById(id).style.display === 'none') document.getElementById(id).style.display = 'block';
			else document.getElementById(id).style.display = 'none';
		}
		function openpopup(event) {
			event.preventDefault();
			if (!validate() || !validate1() || !validate2()) return;
			document.getElementById('cover').style.display = 'block';
			document.getElementById('confirm').style.display = 'block';
		}
		function closepopup(event) {
			event.preventDefault();
			document.getElementById('cover').style.display = 'none';
			document.getElementById('confirm').style.display = 'none';
			document.getElementById('end').style.display = 'none';
		}
		// dopusta samo brojeve (za kvadraturu i cenu)
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
		}
		function clearfiles(target) {
			var f = document.getElementById(target);
			if(f.value){
                f.value = '';
        		if(f.value){
            		var form = document.createElement('form'),
                	parentNode = f.parentNode, ref = f.nextSibling;
            		form.appendChild(f);
            		form.reset();
            		parentNode.insertBefore(f,ref);
        		}
    		}
    		document.getElementById('text').innerHTML = "Nema izabranih slika.";
		}
		function filenumber() {
			var num = document.getElementById('upload').files.length;
			if (num == 1) {
				document.getElementById('text').innerHTML = num + " slika.";
			}
			else {
				document.getElementById('text').innerHTML = num + " slike.";
			}
		}
	</script>
</body>
</html>