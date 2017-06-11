<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
		<style type="text/css">
		.social-links {
			list-style: none;
			padding: 0;
			margin-bottom: 40px;
		}
		.social-links li {
			display: inline-block;
			height: 34px;
			margin-right: 15px;
		}
		.social-links li a {
			text-decoration: none;
			cursor: pointer;
			padding-bottom: 17px;
			padding-left: 34px;
			background-repeat: no-repeat;
			background-position: center;
			background-size: auto 34px;
			opacity: 0.5;
			transition: .4s;
		}
		.social-links li a:hover {
			opacity: 1;
		}
		.footer-link {
			padding-left: 20px;
			padding-right: 20px;
			border-right: 1px solid lightgray;
		}
		.footer-link a {
			text-decoration: none;
			font-weight: 600;
			color: gold;
		}
		.footer-link a:hover {
			text-decoration: underline;
		}
		footer {
			background-color: rgba(0,0,0, 0.8); 
			color: lightgray;
			padding-top: 80px;
			padding-bottom: 80px;
			text-align: center;
		}
	</style>
</head>
<body>
	<footer>
			<div>
				<div><b>Pratite Lemonsqueezy:</b></div>
			</div>
			<ul class="social-links">
				<li><a target="_blank" href="http://www.facebook.com" style="background-image: url('./images/facebook.png');"></a></li>
				<li><a target="_blank" href="http://www.tinder.com" style="background-image: url('./images/twitter.png');"></a></li>
				<li><a target="_blank" href="http://www.twitter.com" style="background-image: url('./images/tinder.png');"></a></li>
				<li style="margin-right: 0;"><a target="_blank" href="http://www.instagram.com" style="background-image: url('./images/instagram.png');"></a></li>
			</ul>
			<div style="font-size: 12px">&copy; <?php echo date("Y");?>. EZPZ tim. Sva prava zadžana.</div>
			<div style="margin-top: 10px">
				<span class="footer-link"><a href="/psi">Glavna</a></span>
				<span class="footer-link"><a href="/psi/pretraga.php">Pretraga</a></span>
				<span class="footer-link"><a href="/psi/login.php">Prijava</a></span>
				<span class="footer-link" style="border-right: none;"><a href="/psi/registracija.php">Registracija</a></span>
			</div>
	</footer>
</body>
</html>