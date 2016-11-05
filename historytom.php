<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="js/jquery-ui.min.css" rel="stylesheet">
  <script src="js/jquery-2.1.1.min.js"> </script>
  <script src="js/jquery-ui.min.js"> </script>
  <script src="js/jquery.form.min.js"> </script>
  <script src="js/jquery.blockUI.js"> </script>
  <title>Mango Store</title>
  <style>
	input[type="submit"]{
	/* change these properties to whatever you want */
	color: #FFF;
  	background-color: #900;
  	font-weight: bold;
	}
 </style>
<title>Online Store</title>
  <style>
      .jumbotron {
    margin-bottom: 0px;
    background-image: url(imgBackground/drops_blur_color_stains.jpg);
    background-position: 0% 25%;
    background-size: cover;
    background-repeat: no-repeat;
    color: white;
    text-shadow: black 0.3em 0.3em 0.3em;
}
    </style>

<style>
	@import "global-order.css";

	form {
		margin: 20px auto;
		width: 70%;
		border: solid 0px;
		font-size: 12px;
		color: green;
	}
	form  > * {
		font: 14px tahoma;
		padding: 3px;
	}
	input {
		width: 200px;
		margin: 3px;
		background: #ffc;
		border: solid 1px gray;
	}
	h2.warning {
		text-align: left !important;
	}
	span#forget-pswd {
		width: 425px;
		display: block;
		text-align: right;
		margin: -5px 0px 10px 0px;
	}
	span#forget-pswd a {
		font-size: 12px;
	}
	#head {
		padding: 5px !important;
	}
	table {
		margin: 20px auto;
		border-collapse: collapse;
	}
	caption {
		text-align: left;
		padding-bottom: 3px !important;
	}
	td:nth-child(1) {
		width: 250px;
		text-align: left !important;
	}
	td:nth-child(2) {
		width: 200px;
		text-align: left !important;
	}
	td:nth-child(3), td:nth-child(4) {
		width: 80px;
	}
	td:nth-child(5), td[colspan]+td {
		width: 100px;
	}
	table th {
		background: green;
		color: yellow;
		padding: 5px;
		border-right: solid 1px white;
		font-size:12px;
	}
	tr:nth-of-type(odd) {
		background: lavender;
	}
	tr:nth-of-type(even) {
		background: whitesmoke;
	}
	td {
		text-align: center;
		vertical-align: top;
		padding: 3px 0px 3px 3px;
		border-right: solid 1px white;
	}
	tr:last-child td {
		border-top: solid 1px white;
		background: powderblue !important;
		padding: 5px;
		font-weight: bold;
		text-align: center !important;
	}
	caption > div {
		float: right;
		color: navy;
	}
	caption img {
		height: 16px;
		float:none;
		vertical-align: bottom;
	}
	h3 {
		text-align: center;
		color: navy;
	}
	div#head > img {
		vertical-align: bottom;
		margin-right: 5px;
		height: 24px;
	}
	h5 {
		text-align: center;
		margin: 0px;
	}
</style>
<script src="js/jquery-2.1.1.min.js"> </script>
<script>
$(function() {
	$('button#index').click(function() {
		location.href = "index2.php";
	});
});
</script>


<style>
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
}

.button1 {
    background-color: white;
    color: black;
    border: 2px solid #4CAF50;
}

.button1:hover {
    background-color: #4CAF50;
    color: white;
}

.button2 {
    background-color: white;
    color: black;
    border: 2px solid #008CBA;
}

.button2:hover {
    background-color: #008CBA;
    color: white;
}

.button3 {
    background-color: white;
    color: black;
    border: 2px solid #f44336;
}

.button3:hover {
    background-color: #f44336;
    color: white;
}

.button4 {
    background-color: white;
    color: black;
    border: 2px solid #e7e7e7;
}

.button4:hover {background-color: #e7e7e7;}

.button5 {
    background-color: white;
    color: black;
    border: 2px solid #555555;
}

.button5:hover {
    background-color: #555555;
    color: white;
}
</style>

<style>
.buttom {
    background-color: #008CBA; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.buttom1 {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}

.buttom2:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
</style>
</head>
<body>

<?php
 include "topbar.php";
?>

<?php
include "dblink.php";

$err = "";
$name = "";
if($_POST['email']) {
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];
	//ตรวจสอบว่าอีเมลและรหัวผ่านที่ใส่เข้ามาถูกต้องหรือไม่
	$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$pswd'";
	$r = mysqli_query($link, $sql);
	if(mysqli_num_rows($r)==0) {
		$err = '<h2 class="warning">ท่านใส่อีเมลหรือรหัสผ่านไม่ถูกต้อง</h2>';
	}
	else {
		$data = mysqli_fetch_array($r);
		$name = $data['firstname'] . "   " . $data['lastname'];

		$cust_id = $data['cust_id'];
		$sql = "SELECT *, DATE_FORMAT(order_date, '%d-%m-%Y') AS order_date
					FROM orders WHERE cust_id = '$cust_id' ORDER BY order_id DESC LIMIT 50";
		$r = mysqli_query($link, $sql);
		if(mysqli_num_rows($r) == 0) {
			echo "<h3>ไม่พบ</h3>";
		}
		echo "<h3>ประวัติการสั่งซื้อของคุณ: $name</h3>";
		while($data = mysqli_fetch_array($r)) {
			$order_id = $data['order_id'];
			$date =  $data['order_date'];
			//กำหนดภาพให้สอดคล้องกับสถานะการโอนเงินและจัดส่ง
			$img_pay = "images/no.png";
			$img_delivery = "images/no.png";
			if($data['paid'] == "yes") {
				$img_pay = "images/yes.png";
			}
			if($data['delivery'] == "yes") {
				$img_delivery = "images/yes.png";
			}
			$sql = "SELECT order_details.*, products.pro_id, products.pro_name, products.price
			 			FROM order_details LEFT JOIN products
						ON order_details.pro_id = products.pro_id
						WHERE order_details.order_id = '$order_id'";
			$result = mysqli_query($link, $sql);
?>
  				<table border="0">
  					<caption>
   	 					วันที่: <?php echo $date; ?> &nbsp;&nbsp;
                        รหัสการสั่งซื้อ: <?php echo $order_id; ?>
  						<div><img src="<?php echo $img_pay; ?>"> การชำระเงิน  -
                         		<img src="<?php echo $img_delivery; ?>"> การจัดส่งสินค้า</div>
  					</caption>
				<tr><th>ชื่อสินค้า</th><th>คุณลักษณะ</th><th>จำนวน</th><th>ราคา</th><th>รวม</th></tr>
				<?php
					$grand_total = 0;
					while($order = mysqli_fetch_array($result)) {
						$sub_total = $order['quantity'] * $order['price'];
				?>
				<tr>
    				<td><?php echo $order['pro_name']; ?></td>
    				<td><?php echo $order['attribute']; ?></td>
    				<td><?php echo $order['quantity']; ?></td>
    				<td><?php echo $order['price']; ?></td>
   					<td><?php echo number_format($sub_total); ?></td>
				</tr>
				<?php
					$grand_total += $sub_total;
				}
				?>
				<tr><td colspan="4">รวมทั้งหมด</td><td><?php echo number_format($grand_total); ?></td></tr>
			</table>
<?php
		}  //end while
	}		//end else
}

//ถ้าไม่มีข้อมูลโพสเข้ามา หรือเกิดข้อผิดพลาด ให้แสดงฟอร์มสำหรับใส่อีเมลและรหัสผ่าน
if(!$_POST || $err != "") {
?>

<br><br><br>
<div class="jumbotron" style="text-align: center">
      <h1 style="text-align: center"><font size="7">ประวัติการสั่งซื้อ</font></h1>
</div>
<div id="container">
<center>
<div id="content">

<form method="post"><br><?php echo $err; ?>
	  <p><font color="black">กรุณาใส่อีเมลและรหัสผ่านที่ท่านใช้ในการสั่งซื้อสินค้า</font></p>
	  <input type="email" name="email" placeholder="อีเมล *" required>
    <input type="password" name="pswd" placeholder="รหัสผ่าน *" maxlength="20" required>
    <button class="button" type="submit">ตกลง</button>
</form>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="forget-password.php">ลืมรหัสผ่าน</a>
<?php
}
?>

</div><br><br><br><br>
<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <!-- Pager -->
                <ul class="pager">
                    <li class="next">
                        <a href="index2.php">&larr; กลับหน้าหลัก</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</center>
</div>

</body>
</html>
<?php  mysqli_close($link); ?>
