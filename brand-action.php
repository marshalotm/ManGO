<?php
include "check-login.php";
if(!$_POST) {
	exit;
}
include "dblink.php";
if($_POST['action'] == "add") {
	$bra = $_POST['bra'];
	$sql = "REPLACE INTO brands VALUES('', '$bra')";
	mysqli_query($link, $sql);
}
if($_POST['action'] == "edit") {
	$bra = $_POST['bra'];
	$id = $_POST['bra_id'];
	$sql = "UPDATE brands SET bra_name = '$bra' WHERE bra_id = $bra_id";
	mysqli_query($link, $sql);
}
if($_POST['action'] == "del") {
	$id = $_POST['bra_id'];
	$sql = "DELETE FROM brands WHERE bra_id = $bra_id";
	mysqli_query($link, $sql);
}
mysqli_close($link);
?>
