<?php
include "dblink.php";
$id = $_GET['id'];
$sql = "SELECT imgpay_content FROM images_pay WHERE imgpay_id = $id";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_array($result);
header("Content-Type: image/jpeg");
echo $data['imgpay_content'];
mysqli_close($link);
?>
