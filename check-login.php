<?php
session_start();
if(!isset($_SESSION['admin'])) {
	header("location: index2.php");
	exit;
}
?>
