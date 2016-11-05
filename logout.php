<?php
session_start();
session_destroy();

//ลบคุกกี้การเข้าสู่ระบบ
$expire = time() - 3600;
setcookie('email', '', $expire);
setcookie('pswd', '', $expire);

//ให้ใช้เฮดเดอร์ refresh เพื่อหน่วงเวลาให้
//PHP สามารถส่งข้อมูลกลับมายังเบราเซอร์ได้
header("refresh: 1; url=index2.php");
?>
<!doctype html>
<html>
<head>
<link rel="shortcut icon" href="mangowhite.png">
<meta charset="utf-8">
<style>
	body {
		cursor: wait;
		text-align: center;
	}
	h3.green {
		color: #060;
	}
</style>
<title>Mango</title>
</head>

<body>
	<h3 class="green">ท่านออกจากระบบแล้ว จะกลับสู่หน้าหลักใน 1 วินาที</h3>
</body>
</html>
