<?php
$db_username = 'root';
$db_password = '';
$db_name = 'psi';
$db_host = 'localhost';
$item_per_page = 2;

$conn = mysqli_connect('localhost', 'root', '', 'psi');
if (!$conn) die("Connection failed: " . mysqli_connect_error());
mysqli_query($conn, "SET NAMES UTF8");

?>