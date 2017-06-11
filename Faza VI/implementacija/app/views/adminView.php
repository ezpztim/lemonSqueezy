<!DOCTYPE html>
<html>
<head>
	<title>Lemon squeezy - Administratorski nalog</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/admin.css">
</head>
<body>
	<div id="cover" class="center" <?php if (isset($_SESSION['msg'])) echo "style='display: block;'"; ?>></div>
	<div id="confirm" class="center">
		<div>Da li ste sigurni?</div><br>
		<div>
			<form method="post" action="odobri.php" style="display: inline;">
				<input type="hidden" name="id" id="odobriId" value=""></input>
				<input type="submit" name="submit" class="button tablebutton" value="Da" style="width: 100px;"></input>
			</form>
			<button type="button" onclick="closepopup(event)" class="button" style="width: 100px;">Ne</button>
		</div>
	</div>
	<div id="confirm2" class="center" style="padding: 15px;">
		<div>Unesite razlog za odbijanje oglasa:</div><br>
		<div>
			<form method="post" action="zabrani.php">
				<input type="hidden" name="id" id="odobriId2" value=""></input>
				<div><input type='text' size='30' name='razlog' placeholder="npr. Nepostojeća ulica" required></input></div><br>
				<div><label><input type='checkbox' name="prestup" style="vertical-align: middle;" value="1">Uvecaj br. prestupa ovog korisnika</label></div><br>
				<input type="submit" name="submit" class="button tablebutton" value="Potvrdi" style="width: 100px;"></input>
				<button type="button" onclick="closepopup(event)" class="button" style="width: 100px;">Odustani</button>
			</form>
		</div>
	</div>
	<?php 
		if (isset($_SESSION['msg'])) {
	?>
			<div id="end" class="center" style="display: block;">
				<div><?php echo $_SESSION['msg'];?></div><br>
				<div style="height: 34px;">
					<button type="button" onclick="closepopup(event)" class="button" style="width: 100px;">Ok</button>
				</div>
			</div>
	<?php
			unset($_SESSION['msg']);
		}
	?>
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
	<div id="infobox"></div>
	<div id="wrapper">
		<div class="header">
			<div class="center">
				<h2>Novi oglasi</h2>
			</div>
		</div>
		<div id="table-holder-outer">
			<div id="table-holder-inner">
				<table class="table" style="margin-top: 3px; margin-bottom: 3px;">
					<tr>
						<th align="center" width="40px">Br.</th>
						<th width="180px">Oglas</th>
						<th width="85px">Datum</th>
						<th>Korisnik</th>
						<th width="90px" align="center">Br. prestupa</th>
						<th align="center" width="140px">Opcije</th>
					</tr>
				</table>
				<div style="overflow-y: scroll; height: calc(100% - 25px); width: calc(100% - 8px);">
					<table class="table">
<?php
	if ($data->num_rows > 0) {
		$i = 1;
		while ($row = $data->fetch_assoc()) {
?>
			<tr>
				<td align="center" width="40px"><?php echo "$i";?></td>
				<td width="180px"><a target="_blank" class="ellipsis" href="./oglasi/<?php echo $row['id'];?>"><?php echo $row['Naziv'];?></a></td>
				<td width="85px"><?php echo date( "d.m.Y.", strtotime($row['DatumObjave']));?></td>
				<td><?php echo $row['name']. " ". $row['surname'];?></td>
				<td width="90px" align="center"><?php echo $row["brprestupa"];?></td>
				<td align="center" width="140px">
					<button title="Odobri oglas" onclick="openpopup(event, <?php echo $row['id'];?>)" class="button tablebutton">Odobri</button>
					<button title="Zabrani oglas" onclick="openspecialpopup(event, <?php echo $row['id'];?>)" class="button tablebutton">Zabrani</button>
				</td>
			</tr>
<?php
			$i++;
		}
	}
	else {
		echo '<div class="center">Nema novih/izmenjenih oglasa za pregled.</div>';
	}
?>		
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="copywright">&copy; <?php echo date("Y");?>. EZPZ tim. Sva prava zadžana.</div>
	<script type="text/javascript">
		function openpopup(event, val) {
			event.preventDefault();
			document.getElementById('cover').style.display = 'block';
			document.getElementById('confirm').style.display = 'block';
			document.getElementById('odobriId').value = val;
		}
		function closepopup(event) {
			event.preventDefault();
			document.getElementById('cover').style.display = 'none';
			document.getElementById('confirm').style.display = 'none';
			document.getElementById('confirm2').style.display = 'none';
			document.getElementById('end').remove();
		}
		function openspecialpopup(event, val) {
			event.preventDefault();
			document.getElementById('cover').style.display = 'block';
			document.getElementById('confirm2').style.display = 'block';
			document.getElementById('odobriId2').value = val;
		}
	</script>
</body>
</html>