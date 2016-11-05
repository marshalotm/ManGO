<?php
session_start();
?>
<!doctype html>
<html>
<head>
<title>Online Store</title>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style>
 input[type="submit"]{
 /* change these properties to whatever you want */
 color: #FFF;
   background-color: #900;
   font-weight: bold;
 }
</style>

 <style>
     .jumbotron {
   margin-bottom: 0px;
   background-image: url(/imgBackground/multicolor.jpg);
   background-position: 0% 25%;
   background-size: cover;
   background-repeat: no-repeat;
   color: white;
   text-shadow: black 0.3em 0.3em 0.3em;
}
</style>

<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery-ui.min.js"> </script>
<script>
$(function() {
	$('[name=date]').datepicker({dateFormat: 'yy/mm/dd'});

	$('button#submit2').click(function() {
		if($('[name=bank] option:selected').index() == 0) {
			alert('กรุณาเลือกธนาคาร');
			return false;
		}
		$('button[type=submit2]').click();
	});

	$('button#index').click(function() {
		location.href = "index2.php";
	});

});
</script>

<script src="js/jquery.blockUI.js"> </script>
<script>
var fileNo = 1;
var fileCount = 1;

$(function() {
	$('#bt-search').click(function() {
		if($(':radio[name=field]:checked').val() == "category") {
			$('#field-text').val($('#cat-search option:selected').text());
		}else if($(':radio[name=field]:checked').val() == "brand"){
      $('#field-text').val($('#bra-search option:selected').text());
    }else if($(':radio[name=field]:checked').val() == "supplier") {
			$('#field-text').val($('#sup-search option:selected').text());
		}
		$('#form-search').submit();
	});

	$('#bt-add-pro').click(function() {
 		showDialog();
	});

	$('#bt-send').click(function(event) {
		var data = $('#form-pro').serializeArray();
		ajaxSend(data);
	});

	fileCount = $('[type=file]').length;
	for(i = 1; i <= fileCount; i++) {
		$('#bt-upload' + i).click(function() {
			uploadFile();
		});
	}

	$('button.edit').click(function() {
		var id = $(this).attr('data-id');
		window.open('product-edit.php?id=' + id);
	});

	$('button.del').click(function() {
		if(!(confirm("ยืนยันการลบสินค้ารายการนี้"))) {
			return;
		}
		var id = $(this).attr('data-id');
		$.ajax({
			url: 'product-delete.php',
			data: {'action': 'del', 'pro_id': id},
			type: 'post',
			dataType: "html",
			beforeSend: function() {
				$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
			},
			success: function(result) {
				location.reload();
			},
			complete: function() {
				$.unblockUI();
			}
		})
	});

});

function resetForm() {
	$('#form-pro')[0].reset();
	$('input:file').clearInputs();  //อยู่ในไลบรารี form.js
}

function showDialog() {
	fileNo = 1;
	resetForm();
	$('#dialog').dialog({
		title: 'เพิ่มสินค้า',
		width: 'auto',
		modal: true,
		position: { my: "center top", at: "center top", of: $('nav')}
	});
}

function ajaxSend(dataJSON) {
	$.ajax({
		url: 'product-add.php',
		data: dataJSON,
		type: 'post',
		dataType: "html",
		beforeSend: function() {
			$.blockUI({message:'<h3>กำลังส่งข้อมูล...</h3>'});
		},
		success: function(result) {
			$('#bt-upload' + fileNo).click();
		},
		complete: function() {
			//$.unblockUI();
		}
	});
}

function uploadFile() {
	if(fileNo > fileCount) {
		return;
	}
	var input = '#file' + fileNo;
	$('#form-img'  + fileNo).ajaxForm({
		dataType: 'html',
		beforeSend: function() {
			if($(input).val().length != 0) {
				$.blockUI({message:'<h3>กำลังอัปโหลดภาพที่ ' + fileNo + '</h3>'});
			}
		},
		success: function(result) {	},
		complete: function() {
			fileNo++;
			if(fileNo <= fileCount) {
				$('#bt-upload' + fileNo).click();
			}
			else {
				fileNo = 1;
				$('#dialog').dialog('close');
				$.unblockUI();
				location.reload();
			}
		}
	});
}
</script>

</head>
<body>
  <?php
   include "topbar.php";
  ?>
<br>
<br>

<?php
$err = "";
if($_POST) {
	include "dblink.php";
	$email = $_POST['email'];
	$pswd = $_POST['pswd'];
 	$sql = "SELECT cust_id FROM customers WHERE email = '$email' AND password = '$pswd'";
	$r = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($r);
	if(mysqli_num_rows($r)==1) {
		$cust_id = $row[0];

		$order_id = $_POST['order_id'];
		$sql = "SELECT COUNT(*) FROM orders WHERE order_id = '$order_id' AND cust_id = '$cust_id'";
		$r = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($r);
		$c = $row[0];
		if($c == 1) {
			$bank = $_POST['bank'];

			$bath = $_POST['bath'];
			$satang = $_POST['satang'];
			if(!empty($satang)) {
				$bath .= ".$satang";
			}
			else {
				$bath .= ".00";
			}
			$h = $_POST['hour'];
			$m = $_POST['min'];
			$dt = $_POST['date'] . " $h:$m";
			$sql = "INSERT INTO payments VALUES(
						'', '$order_id', '$cust_id', '$bank', '$bath', '$dt', 'no')";
			if(!mysqli_query($link, $sql)) {
				$err = "ไม่สามารถบันทึกข้อมูล กรุณาตรวจสอบการใส่ข้อมูลของท่าน";
			}
			else {
				echo "<h2>เราจัดเก็บข้อมูลการโอนเงินของท่านแล้ว<br>
				 		และจะทำการตรวจสอบในลำดับต่อไป<br>
						ขอบคุณค่ะ</h2>";
			}
		}
		else {
			$err = "ไม่พบรหัสการสั่งซื้อ: $order_id";
		}
	}
	else {
		$err = "ท่านใส่อีเมลหรือรหัสผ่านไม่ถูกต้อง";
	}

	if($err != "") {
		echo '<h2 class="warning">'. $err . "</h2>";
	}
	mysqli_close($link);
}
if(!$_POST || $err != "") {
?>

  <div class="jumbotron" style="text-align: center">
      <h1 style="text-align: center"><font size="7">แจ้งการโอนเงิน</font></h1>
    </div>

 <div class="container">
 	 <div class="col-md-1">

 	 </div>
 	 <div class="col-md-6">
 	 	<br>
	    <p style="color:red;">กรุณาใส่ข้อมูลให้ครบสมบูรณ์ เพื่อป้องกันข้อผิดพลาดในการตรวจสอบ</p>
 	 </div>
 </div>

 <div class="container">
   	<div class="row">

   	</div>
 </div>

 <br>

 <div class="container">
	<div class="row">
		<div class="col-md-1">

		</div>
		<div class="col-md-2">
			<br><br><br><br><br><br><br><br><br>
			<p>บัญชีที่โอนเงิน &nbsp;<b>:</b></p>
		</div>
		<div class="col-md-6">
			<form>
				<div class="radio">
     					<label><img src="imgBank/KBANK.jpg"style="width:40px;height:35px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ธ.กสิกรไทย &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0033192088 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สาขา ชัยนาท</label>
    			</div>
    			<hr>
   				<div class="radio">
     					 <label><img src="imgBank/SCB.jpg"style="width:40px;height:35px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ธ.ไทยพาณิชย์ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6152275387 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สาขา ชัยนาท</label>
    			</div>
    			<hr>
    			<div class="radio">
     				 <label><img src="imgBank/BAY.jpg"style="width:40px;height:35px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ธ.กรุงศรีอยุธยา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0821463936 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สาขา ชัยนาท</label>
    			</div>
    			<hr>
    			<div class="radio">
      				<label><img src="imgBank/KTB.jpg"style="width:40px;height:35px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ธ.กรุงไทย &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1060542331 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สาขา ชัยนาท</label>
    			</div>
    			<hr>
    			<div class="radio">
      				<label><img src="imgBank/BBL.jpg"style="width:40px;height:35px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ธ.กรุงเทพ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3820803371 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สาขา ชัยนาท</label>
    			</div>
    			<hr>
    			<div class="radio">
      				<label><img src="imgBank/TMB.jpg"style="width:40px;height:35px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ธ.ทหารไทย &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3712284607 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สาขา ชัยนาท</label>
    			</div>
			</form>
		</div>
	</div>
	<br><br>
	<div>
		<div class="row">
			<div class="col-md-1">

			</div>

			<div class="col-md-8">


        <?php
           include "addpayimg.php";
        ?>

<br>
<br>

<form method="post">

        อีเมล ที่ท่านใช้ในการสั่งซื้อ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>:</b> &nbsp;&nbsp;&nbsp;&nbsp; <input type="email" name="email" placeholder="อีเมล *">
        <br><br>
        รหัสผ่าน ที่ท่านใช้ในการสั่งซื้อ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>:</b> &nbsp;&nbsp;&nbsp;&nbsp; <input type="password" name="pswd" placeholder="รหัสผ่าน *">
        <br><br>
        รหัสการสั่งซื้อ ที่ท่านได้รับทางอีเมล &nbsp;<b>:</b> &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="order_id" placeholder="รหัสการสั่งซื้อ *" required >
        <br><br>
         <select name="bank">
          <option>โอนผ่านธนาคาร *</option>
          <option value="กสิกรไทย">- กสิกรไทย</option>
          <option value="ไทยพาณิชย์">- ไทยพาณิชย์</option>
          <option value="กรุงเทพ">- กรุงศรีอยุธยา</option>
          <option value="กรุงไทย">- กรุงไทย</option>
          <option value="กรุงเทพ">- กรุงเทพ</option>
          <option value="กรุงเทพ">- ทหารไทย</option>
        </select>
        <br><br>
        จำนวนเงิน (บาท - สตางค์) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" name="bath" placeholder="จำนวนเงิน(บาท) *" required > &nbsp;&nbsp;
        <input type="number" name="satang" placeholder="สตางค์">
        <br><br>
        วันเดือนปี - เวลา (ชั่วโมง นาที) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>:</b> &nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="date" placeholder="วันเดือนปี *" required > &nbsp;

        <input type="number" name="hour" placeholder="ชั่วโมง *" min="0" max="23" required>
        <input type="number" name="min" placeholder="นาที *"  min="0" max="59" required>
        <br><br>

        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="submit2" style="display:none;"></button>



      <!-- วันที่ชำระเงิน : &nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="bday"> -->
</form>
<?php
$show_submit = true;
}
?>

<button id="index">&laquo; หน้าแรก</button>
<?php
if($show_submit) {
	echo '<button id="submit2">ส่งข้อมูล &raquo;</button>';
}
?>
 </div>
 </div>
 </div>
 </div>
</body>
</html>
