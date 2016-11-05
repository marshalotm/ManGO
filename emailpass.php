<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Case</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- php --->
<?php
if($_POST) {
	include "dblink.php";

  $email = $_POST['email'];
	$err = "";
	$msg = "";

	//$sql = "SELECT password FROM member WHERE email='$email'";
	$sql = "SELECT * FROM customers
		 		WHERE  email = '$email'";

    $rs = mysqli_query($link, $sql);
	$data = mysqli_fetch_array($rs);
	if(mysqli_num_rows($rs) == 0) {
		$err  = 'ท่านใส่อีเมลไม่ถูกต้อง';
	}

	else {

	   //send email
       $to = "<$email>";
       $subject = "Mango store service";
       $txt = "Password : $data[2]";     //เนื่องจาก password อยู่ช่องที่ 3 ในตาราง table จึงต้อง data[2]

       $headers = "From:noreply@mango.com" . "\r\n" .
        "CC:noreply@mango.com";

       $flgSend = mail($to,$subject,$txt,$headers);
       if($flgSend)
       {
         //echo "ทำการส่งรหัสยืนยันเรียบร้อย...";
       }
      else
      {
         echo "Mail cannot send.";
      }
	}

	if($err != "") {
		echo "<div><h3 class=\"red\">$err</h3></div>";
	}
	else if($msg != "") {
		echo "<h3>$msg</h3><br>";
		echo '<a href="index2.php">กลับหน้าหลัก</a>';
		mysqli_close($link);
		exit('</body></html>');
	}
	mysqli_close($link);
}
?>


<div class="container">
  <h3>ส่งรหัสผ่านของอีเมลของท่านแล้ว...</h3>
  <br>
  <a href="index2.php" class="btn btn-default btn-lg active" role="button">กลับสู่หน้าหลัก</a>




</body>
</html>
