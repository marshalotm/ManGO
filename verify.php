<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mango Store</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
  <!---- php ----->
  <?php
  if($_POST) {
  	include "dblink.php";


  	$code = $_POST['code'];
  	$email = $_POST['email'];
  	$target = $_POST['target'];
  	$err = "";
  	$msg = "";

  	//ถ้าเลือกการยืนยันรหัส
  	if($target == "verify") {
  		$sql = "UPDATE customers SET verify = ''
  		 			WHERE  email = '$email' AND verify = '$code'";

  	 	$rs = mysqli_query($link, $sql);

  		//ถ้าเกิดการเปลี่ยนแปลง แสดงว่าใส่รหัสถูกต้อง
  		if(mysqli_affected_rows($link) == 0) {
  			$err = "ท่านใส่อีเมลหรือรหัสยืนยันไม่ถูกต้อง";
  		}
  		else {
  			$msg = "การยืนยันของท่านเสร็จเรียบร้อยแล้ว";
  		}
  	}

  	//ถ้าขอให้ส่งรหัสไปให้ใหม่
  	else if($target == "re-code") {
  		//กรณีนี้เราต้องอ่านรหัสจากตาราง แล้วส่งไปทางอีเมล
  		$sql = "SELECT verify FROM customers WHERE email = '$email'";
  		$rs = mysqli_query($link, $sql);
  		$data = mysqli_fetch_array($rs);

  		if(mysqli_num_rows($rs)==0) {
  			$err  = "ไม่พบอีเมลที่ท่านระบุ";		//ถ้าไม่มีข้อมูลแสดงว่าใส่อีเมลผิด
  		}
  		else if(empty($data[0])) {
  			$err = "ท่านยืนยันรหัสนี้ไปแล้ว";
  		}
  		else {
  			$code = $data[0];


  			//ini_set("SMTP", "smtp.totisp.net");
  			//include "thaimailer.php";
  			//mail_from("admin<admin@example.com>");
  			//mail_to("<$email>");
  			//mail_subject("รหัสยืนยันการสมัครสมาชิก");
  			//mail_body("รหัสการยืนยันคือ: $code");
  			//if(mail_send()) {  //แม้ส่งสำเร็จ แต่ให้เหมือนกับเกิดข้อผิดพลาด
  			//	$err = "ส่งรหัสการยืนยันไปทางอีเมลแล้ว";
  			//}
  			//else {
  				//$err = "เกิดข้อผิดพลาดในการส่งอีเมล";
  			//}

  	   //send email
         $to = "<$email>";
         $subject = "Mango store service";
         $txt = "Verification codes : $code";
         $headers = "From:noreply@mango.com" . "\r\n" .
          "CC:noreply@mango.com";

          $flgSend = mail($to,$subject,$txt,$headers);
          if($flgSend)
          {
            echo "ทำการส่งรหัสยืนยันเรียบร้อย...";
          }
         else
          {
            echo "Mail cannot send.";
          }



  		}
  	}

  	if($err != "") {
  		echo '<div>';
  		echo "<h3 class=\"red\">$err</h3>";
  		echo '</div>';
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
 <!--- END PHP ----->
 <?php
 include "topbar.php";
 ?>

	<br><br><br><br>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="site-heading">
                     <h1><font size="8">Mango ID</font></h1>
                     <font size="5">ยืนยันการสมัครสมาชิก</font><br><br>

                     <form method="post">


                            <div class="form-group">
                                 <input type="text" class="form-control" name="email" placeholder="อีเมล" required>
                                  <br>
                                 <input type="password" class="form-control" name="code" placeholder="รหัสยืนยันที่ได้รับทางอีเมล">
                             </div>



                             <label class="radio-inline">
                                 <input type="radio" name="target" value="verify" checked><font size="2.5"> ยืนยันการสมัคร</font>
                             </label>

                             <label class="radio-inline">
                                 <input type="radio" name="target" value="re-code"><font size="2.5"> ขอรหัสใหม่(ใส่แค่อีเมลแล้วส่งข้อมูล)</font>
                             </label>

                            <br>
                            <br>

                            <span>
                             	  	<button style="font-size:12pt;color:white;background-color:green;border:4px solid #336600;padding:6px">ส่งข้อมูล</button>
                            </span>

                    </form>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-4 col-md-10 col-md-offset-4">
                <!-- Pager -->
                <ul class="pager">
                    <li class="next">
                        <a href="index2.php">&larr; กลับหน้าหลัก</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/clean-blog.min.js"></script>

</body>

</html>
