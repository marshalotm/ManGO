<!DOCTYPE html>
<html lang="th">
<head>
  <title>Mango Store</title>
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
    background-image: url(imgBackground/spots_background_light_solid_color_69091_3840x1200.jpg);
    background-position: 0% 25%;
    background-size: cover;
    background-repeat: no-repeat;
    color: white;
    text-shadow: black 0.3em 0.3em 0.3em;
}
    </style>

</head>
<body>

<?php include "topbar.php"; ?>



<!--- end php -->
  <br><br>
  <div class="jumbotron" style="text-align: center">
      <h1 style="text-align: center"><font size="7">ลืมรหัสผ่าน</font></h1>
  </div>

  <div class="container-fluid">

  <form method="post" form action="emailpass.php">
  <h2 style="text-align: center">ป้อน Mango ID ของคุณเพื่อเริ่มต้น</h2>
  <p style="text-align: center"><font size="2">คุณมาถูกที่แล้วสำหรับการรีเซ็ตรหัสผ่านที่คุณลืม ปลดล็อคบัญชี<br>ของคุณ หรือกู้คืน Mango ID</font></p>
   <div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
    	<form>
   	   		 <div class="col-xs-12">

          <form method="post">
       			 <input class="form-control" type="text" name="email"  placeholder="อีเมลที่ท่านใช้สมัครสมาชิก" required><br><br>

             <span>
     		            <p style="text-align: center"><button>ส่งข้อมูล</button></p>
                    <br class="clear">
             </span>

          </form>

     		  </div>
 	    </form>
    </div>
   </div>


  </div>
  <br><br><br><br><br>
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

</body>
</html>
