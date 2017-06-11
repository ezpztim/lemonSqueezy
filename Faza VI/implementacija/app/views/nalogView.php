<!DOCTYPE html>
<html>
<head>
	<title>Lemon Squeezy - Moj nalog</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/account.css">
</head>
<body>
	<div id="cover" class="center" <?php if (isset($_SESSION['msg'])) echo "style='display: block;'"; ?>></div>
	<div id="confirm" class="center">
		<div>Da li ste sigurni?</div><br>
		<div>
			<form method="post" action="izbrisi.php" style="display: inline;">
				<input type="hidden" name="id" id="odobriId" value=""></input>
				<input type="submit" name="submit" class="button tablebutton" value="Da" style="width: 100px;"></input>
			</form>
			<button type="button" onclick="closepopup(event)" class="button" style="width: 100px;">Ne</button>
		</div>
	</div>
	<?php if (isset($_SESSION['msg'])) {?>
		<div id="end" class="center" style="display: block;">
			<div><?php echo $_SESSION['msg'];?></div><br>
			<div style="height: 34px;">
				<button type="button" onclick="closepopup(event)" class="button" style="width: 100px;">Ok</button>
			</div>
		</div>
	<?php unset($_SESSION['msg']); }?>
	<div id="nav">
		<div id="backhome" class="middle">
			<div id="home">&laquo; <a href="./" title="Nazad na glavnu stranicu">Glavna</a></div>
		</div>
		<div class="center"><h2>Moj nalog</h2></div>
		<div id="account-button-holder">
			<span style="vertical-align: middle;"><?php echo $_SESSION['username']." ".$_SESSION['usersurname'];?>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
			<a href="./nalog.php" title="Moj nalog"><button class="button">Moj nalog</button></a>
			<a href="./logout.php" title="Odjava sa mog naloga"><button class="button">Odjava</button></a>
		</div>
	</div>
	<div id="wrapper">
		<div id="wrapper-left">
			<div class="header">
				<div class="center">
					<h2>Oglasi</h2>
				</div>
			</div>
			<div id="table-holder-outer">
				<div id="table-holder-inner">
					<table class="table" style="margin-top: 3px; margin-bottom: 3px;">
						<tr>
							<th align="center" width="40px">Broj</th>
							<th width="180px">Oglas</th>
							<th>Status</th>
							<th align="center" width="130px">Opcije</th>
						</tr>
					</table>
					<div style="overflow-y: scroll; height: calc(100% - 25px); width: calc(100% - 8px);">
						<table class="table">
<?php
	$result = $data['result'];
	if (count($result) > 0) {
		$i = 1;
		while ($row = $result->fetch_assoc()) {
?>
			<tr>
				<td align="center" width="40px"><?php echo "$i";?></td>
				<td width="180px"><a target="_blank" class="ellipsis" href="./oglasi/<?php echo $row['id'];?>"><?php echo $row['Naziv'];?></a></td>
				<td style="color: <?php 
					$status_wait = false;
					if (strcmp($row['Status'], "Odobren") == 0) echo "green";
					elseif (strcmp($row['Status'], "Odbijen") == 0) echo "red";
					else {echo "gray"; $status_wait = true;}
				?>"><?php echo $row['Status']; if (strcmp($row['Status'], "Odbijen") == 0) echo " (" . $row['Razlog']. ")";?></td>
				<td width="130px" align="center">
					<form method="post" action="izmeni.php" style="display: inline;">
						<input type="hidden" name="id" value="<?php echo $row['id'];?>"></input>
						<input type="submit" name="submit" title="Izmeni oglas" class="button tablebutton" value="Izmeni" <?php if ($status_wait) echo "disabled";?>></input>
					</form>
					<button onclick="openspecialpopup(event, <?php echo $row['id'];?>)" class="button" type="button tablebutton" title="Izbriši oglas" <?php if ($status_wait) echo "disabled";?>>Izbriši</button>					
				</td>
			</tr>
<?php
			$i++;
		}
	}
	else {
		echo '<div class="center">Niste kreirali nijedan oglas.<br>Da biste kreirali oglas pritisnite na dugme "Novi oglas".</div>';
	}
?>							
						</table>
					</div>
				</div>
			</div>
			<div>
				<a href="./novi.php" title="Kreiraj novi oglas"><button id="newadd" class="button">Novi oglas</button></a>
			</div>
		</div>
		<div id="wrapper-right">
			<div id="rules">
				<div class="header">
					<div class="center">
						<h2>Pravila</h2>
					</div>
				</div>
				<div style="padding: 10px;">
					<ul>
						<li>Moguće je kačiti neograničen broj oglasa.</li>
						<li>Svi okačeni oglasi se mogu izmeniti ili izbrisati, osim onih koji čekaju odobrenje administratora.</li>
						<li>Svi oglasi će biti pregledani od strane administratora (i nakon kreiranja i nakon izmene).</li>
						<li>Oglasi sa greškama (npr. nepostojeća ulica) će biti odbijeni uz kratko obrazloženje i biće omogućena ispravka grešaka.</li>
						<li>Oglasi sa neprikladnim sadržajem će biti odbijeni uz kratko obrazloženje i biće omogućena ispravka sadržaja.</li>
						<li>Nakon 3 prestupa (kačenja oglasa sa neprikladnim sadržajem) nalog se automatski suspenduje i brišu se svi oglasi tog korisnika.</li>
					</ul>
				</div>
			</div>
			<div id="brokenrules" style="margin-top: 20px">
				<div style="padding: 10px; text-align: center">
					<b>Broj prestupa:</b>&nbsp;
					<?php 
						$brprestupa = $data['brprestupa'];
						if ($brprestupa == 0) echo "<span style='color:green'>";
						if ($brprestupa == 1) echo "<span style='color:yellow'>";
						if ($brprestupa == 2) echo "<span style='color:red'>";
						echo "$brprestupa</span>";
					?>					
				</div>
			</div>
		</div>
	</div>
	<div id="copywright">&copy; <?php echo date("Y");?>. EZPZ tim. Sva prava zadržana.</div>
	<script type="text/javascript">
		function closepopup(event) {
			event.preventDefault();
			document.getElementById('cover').style.display = 'none';
			document.getElementById('confirm').style.display = 'none';
			document.getElementById('end').remove();
		}
		function openspecialpopup(event, val) {
			event.preventDefault();
			document.getElementById('cover').style.display = 'block';
			document.getElementById('confirm').style.display = 'block';
			document.getElementById('odobriId').value = val;
		}
	</script>
</body>
</html>