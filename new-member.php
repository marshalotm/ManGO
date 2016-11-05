<?php session_start();  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" href="../img/mangowhite.png">
    <title>ManGO | IT Shop for you</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/mango.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
      .jumbotron {
    margin-bottom: 0px;
    background-image: url(https://wallpaperscraft.com/image/stains_light_color_background_47319_3840x1200.jpg);
    background-position: 0% 25%;
    background-size: cover;
    background-repeat: no-repeat;
    color: white;
    text-shadow: black 0.3em 0.3em 0.3em;
}
    </style>
  </head>
  <body>
    <!---PHP --->
    <?php
    if($_POST) {
    	//include "dblink.php";

    	 //connect Database
         $servername = "localhost";
         $username = "root";
         $pwds = "mango592016";
         $dbname = "mangostore";

         $link = mysqli_connect($servername,$username,$pwds,$dbname);
         if(!$link)
         {
           die("Fail to connect Database: " . mysqli_connect_error());
         }
          //Change character set to utf8
          mysqli_set_charset($link,"utf8");

    	//post to database
    	$name = $_POST['name'];
    	$lname = $_POST['lname'];
    	$email = $_POST['email'];
    	$pw1 = $_POST['pswd'];
    	$address = $_POST['address'];
    	$phone = $_POST['phone'];

        //define for check
    	$pw2 = $_POST['pswd2'];




    	$err = "";
    	if($pw1 !== $pw2) {
    		$err .= "<li>ใส่รหัสผ่านทั้งสองครั้งไม่ตรงกัน</li>";
    	}

    	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    		$err .= "<li>อีเมลไม่ถูกต้องตามรูปแบบ</li>";
    	}

    	//ตรวจสอบว่าอีเมลนี้ใช้สมัครไปแล้วหรือยัง
    	$sql = "SELECT COUNT(*) FROM customers WHERE email = '$email'";
    	$rs = mysqli_query($link, $sql);
    	$data = mysqli_fetch_array($rs);
    	if($data[0] != 0) {
    		$err  .= "<li>อีเมลนี้เป็นสมาชิกอยู่แล้ว</li>";
    	}

    	if($_POST['captcha'] !== $_SESSION['captcha']) {
    		$err .= "<li>ใส่อักขระไม่ตรงกับในภาพ</li>";
    	}

    	//ถ้ามีข้อผิดพลาดอะไรบ้าง ก็แสดงออกไปทั้งหมด
    	if($err != "") {
    		echo '<div>';
    		echo '<h3 class="red">เกิดข้อผิดพลาดดังนี้คือ</h3>';
    		echo "<ul class=\"red\">$err</ul>";
    		echo '</div>';
    	}
    	else {	//ถ้าไม่มีข้อผิดพลาด
    		$rand = mt_rand(100000, 999999);	  //verify code

    		$sql = "INSERT INTO customers VALUES(
    					'', '$email', '$pw1', '$name', '$lname', '$address' , '$phone','$rand')";  //ใส่ข้อมูลจากตัวแปรลงตามช่อง

    		mysqli_query($link, $sql);


           //send email
           $to = "<$email>";
           $subject = "Mango store service";
           $txt = "Verification codes : $rand";
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

             echo "<h3>จัดเก็บข้อมูลของท่านเรียบร้อยแล้ว</h3><br>";
             echo "เราได้จัดส่งรหัสการยืนยันไปทางอีเมลที่ท่านใช้สมัครแล้ว<br>";
             echo 'กรุณานำรหัสดังกล่าวมายืนยันหลังจากล็อกอินเข้าสู่ระบบตามปกติ</a><br><br>';
             echo '<a href="index2.php">กลับหน้าหลัก</a>';;
             mysqli_close($link);
             exit('</body></html>');
        }
          mysqli_close($link);
      }
     ?>
    <!-- END PHP --->

    <!--bar top-->
    <?php
     include "topbar.php";
    ?>
    <!-- end bar top-->
    <br>
    <br>
  

    <!--container-->
    <div class="container">
      <div class="row">


      </div>
    </div>

    <div class="jumbotron" style="text-align: center">
      <h1 style="text-align: center"><font size="7">สร้าง Mango ID ของคุณ</font></h1>
    </div>

<form method="post">
    <div class="container">
      <div class="row">
        <br><br>
         <p style="text-align: center"><font size="4">Mango ID คือบัญชีเดียวเท่านั้นที่คุณต้องการสำหรับการใช้บริการทุกอย่างจาก Mango</font></p>
      </div><br>
    </div>
    <div class="col-md-4 col-md-offset-4">
      <form>
        <div class="form-group">

         <div class="col-xs-12" >
           <input class="form-control" name="email" type="text"  placeholder="อีเมลสำหรับล็อกอิน">
         </div><br><br><br>

         <div class="col-xs-12" >
           <input class="form-control" name="pswd" type="password"  placeholder="รหัสผ่าน">
         </div><br><br>

         <div class="col-xs-12" >
           <input class="form-control" name="pswd2" type="password"  placeholder="ใส่รหัสผ่านซ้ำ">
         </div><br><br><br>


         <div class="col-xs-12" >
           <input class="form-control" name="name" type="text"  placeholder="ชื่อ">
         </div><br><br><br>

         <div class="col-xs-12" >
           <input class="form-control" name="lname" type="text"  placeholder="นามสกุล">
         </div><br><br><br>

         <div class="col-xs-12" >
           <input class="form-control" name="address" type="text"  placeholder="ที่อยู่">
         </div><br><br><br>

         <div class="col-xs-12" >
           <input class="form-control" name="phone" type="text"  placeholder="เบอร์โทรศัพท์">
         </div><br><br><br>


         <div class="col-xs-12" >
          <select style="width: 470px;">
   <option value="" disabled selected>ประเทศ/ภูมิภาค</option>
  <option value="AF">Afghanistan</option>
  <option value="AX">Åland Islands</option>
  <option value="AL">Albania</option>
  <option value="DZ">Algeria</option>
  <option value="AS">American Samoa</option>
  <option value="AD">Andorra</option>
  <option value="AO">Angola</option>
  <option value="AI">Anguilla</option>
  <option value="AQ">Antarctica</option>
  <option value="AG">Antigua and Barbuda</option>
  <option value="AR">Argentina</option>
  <option value="AM">Armenia</option>
  <option value="AW">Aruba</option>
  <option value="AU">Australia</option>
  <option value="AT">Austria</option>
  <option value="AZ">Azerbaijan</option>
  <option value="BS">Bahamas</option>
  <option value="BH">Bahrain</option>
  <option value="BD">Bangladesh</option>
  <option value="BB">Barbados</option>
  <option value="BY">Belarus</option>
  <option value="BE">Belgium</option>
  <option value="BZ">Belize</option>
  <option value="BJ">Benin</option>
  <option value="BM">Bermuda</option>
  <option value="BT">Bhutan</option>
  <option value="BO">Bolivia, Plurinational State of</option>
  <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
  <option value="BA">Bosnia and Herzegovina</option>
  <option value="BW">Botswana</option>
  <option value="BV">Bouvet Island</option>
  <option value="BR">Brazil</option>
  <option value="IO">British Indian Ocean Territory</option>
  <option value="BN">Brunei Darussalam</option>
  <option value="BG">Bulgaria</option>
  <option value="BF">Burkina Faso</option>
  <option value="BI">Burundi</option>
  <option value="KH">Cambodia</option>
  <option value="CM">Cameroon</option>
  <option value="CA">Canada</option>
  <option value="CV">Cape Verde</option>
  <option value="KY">Cayman Islands</option>
  <option value="CF">Central African Republic</option>
  <option value="TD">Chad</option>
  <option value="CL">Chile</option>
  <option value="CN">China</option>
  <option value="CX">Christmas Island</option>
  <option value="CC">Cocos (Keeling) Islands</option>
  <option value="CO">Colombia</option>
  <option value="KM">Comoros</option>
  <option value="CG">Congo</option>
  <option value="CD">Congo, the Democratic Republic of the</option>
  <option value="CK">Cook Islands</option>
  <option value="CR">Costa Rica</option>
  <option value="CI">Côte d'Ivoire</option>
  <option value="HR">Croatia</option>
  <option value="CU">Cuba</option>
  <option value="CW">Curaçao</option>
  <option value="CY">Cyprus</option>
  <option value="CZ">Czech Republic</option>
  <option value="DK">Denmark</option>
  <option value="DJ">Djibouti</option>
  <option value="DM">Dominica</option>
  <option value="DO">Dominican Republic</option>
  <option value="EC">Ecuador</option>
  <option value="EG">Egypt</option>
  <option value="SV">El Salvador</option>
  <option value="GQ">Equatorial Guinea</option>
  <option value="ER">Eritrea</option>
  <option value="EE">Estonia</option>
  <option value="ET">Ethiopia</option>
  <option value="FK">Falkland Islands (Malvinas)</option>
  <option value="FO">Faroe Islands</option>
  <option value="FJ">Fiji</option>
  <option value="FI">Finland</option>
  <option value="FR">France</option>
  <option value="GF">French Guiana</option>
  <option value="PF">French Polynesia</option>
  <option value="TF">French Southern Territories</option>
  <option value="GA">Gabon</option>
  <option value="GM">Gambia</option>
  <option value="GE">Georgia</option>
  <option value="DE">Germany</option>
  <option value="GH">Ghana</option>
  <option value="GI">Gibraltar</option>
  <option value="GR">Greece</option>
  <option value="GL">Greenland</option>
  <option value="GD">Grenada</option>
  <option value="GP">Guadeloupe</option>
  <option value="GU">Guam</option>
  <option value="GT">Guatemala</option>
  <option value="GG">Guernsey</option>
  <option value="GN">Guinea</option>
  <option value="GW">Guinea-Bissau</option>
  <option value="GY">Guyana</option>
  <option value="HT">Haiti</option>
  <option value="HM">Heard Island and McDonald Islands</option>
  <option value="VA">Holy See (Vatican City State)</option>
  <option value="HN">Honduras</option>
  <option value="HK">Hong Kong</option>
  <option value="HU">Hungary</option>
  <option value="IS">Iceland</option>
  <option value="IN">India</option>
  <option value="ID">Indonesia</option>
  <option value="IR">Iran, Islamic Republic of</option>
  <option value="IQ">Iraq</option>
  <option value="IE">Ireland</option>
  <option value="IM">Isle of Man</option>
  <option value="IL">Israel</option>
  <option value="IT">Italy</option>
  <option value="JM">Jamaica</option>
  <option value="JP">Japan</option>
  <option value="JE">Jersey</option>
  <option value="JO">Jordan</option>
  <option value="KZ">Kazakhstan</option>
  <option value="KE">Kenya</option>
  <option value="KI">Kiribati</option>
  <option value="KP">Korea, Democratic People's Republic of</option>
  <option value="KR">Korea, Republic of</option>
  <option value="KW">Kuwait</option>
  <option value="KG">Kyrgyzstan</option>
  <option value="LA">Lao People's Democratic Republic</option>
  <option value="LV">Latvia</option>
  <option value="LB">Lebanon</option>
  <option value="LS">Lesotho</option>
  <option value="LR">Liberia</option>
  <option value="LY">Libya</option>
  <option value="LI">Liechtenstein</option>
  <option value="LT">Lithuania</option>
  <option value="LU">Luxembourg</option>
  <option value="MO">Macao</option>
  <option value="MK">Macedonia, the former Yugoslav Republic of</option>
  <option value="MG">Madagascar</option>
  <option value="MW">Malawi</option>
  <option value="MY">Malaysia</option>
  <option value="MV">Maldives</option>
  <option value="ML">Mali</option>
  <option value="MT">Malta</option>
  <option value="MH">Marshall Islands</option>
  <option value="MQ">Martinique</option>
  <option value="MR">Mauritania</option>
  <option value="MU">Mauritius</option>
  <option value="YT">Mayotte</option>
  <option value="MX">Mexico</option>
  <option value="FM">Micronesia, Federated States of</option>
  <option value="MD">Moldova, Republic of</option>
  <option value="MC">Monaco</option>
  <option value="MN">Mongolia</option>
  <option value="ME">Montenegro</option>
  <option value="MS">Montserrat</option>
  <option value="MA">Morocco</option>
  <option value="MZ">Mozambique</option>
  <option value="MM">Myanmar</option>
  <option value="NA">Namibia</option>
  <option value="NR">Nauru</option>
  <option value="NP">Nepal</option>
  <option value="NL">Netherlands</option>
  <option value="NC">New Caledonia</option>
  <option value="NZ">New Zealand</option>
  <option value="NI">Nicaragua</option>
  <option value="NE">Niger</option>
  <option value="NG">Nigeria</option>
  <option value="NU">Niue</option>
  <option value="NF">Norfolk Island</option>
  <option value="MP">Northern Mariana Islands</option>
  <option value="NO">Norway</option>
  <option value="OM">Oman</option>
  <option value="PK">Pakistan</option>
  <option value="PW">Palau</option>
  <option value="PS">Palestinian Territory, Occupied</option>
  <option value="PA">Panama</option>
  <option value="PG">Papua New Guinea</option>
  <option value="PY">Paraguay</option>
  <option value="PE">Peru</option>
  <option value="PH">Philippines</option>
  <option value="PN">Pitcairn</option>
  <option value="PL">Poland</option>
  <option value="PT">Portugal</option>
  <option value="PR">Puerto Rico</option>
  <option value="QA">Qatar</option>
  <option value="RE">Réunion</option>
  <option value="RO">Romania</option>
  <option value="RU">Russian Federation</option>
  <option value="RW">Rwanda</option>
  <option value="BL">Saint Barthélemy</option>
  <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
  <option value="KN">Saint Kitts and Nevis</option>
  <option value="LC">Saint Lucia</option>
  <option value="MF">Saint Martin (French part)</option>
  <option value="PM">Saint Pierre and Miquelon</option>
  <option value="VC">Saint Vincent and the Grenadines</option>
  <option value="WS">Samoa</option>
  <option value="SM">San Marino</option>
  <option value="ST">Sao Tome and Principe</option>
  <option value="SA">Saudi Arabia</option>
  <option value="SN">Senegal</option>
  <option value="RS">Serbia</option>
  <option value="SC">Seychelles</option>
  <option value="SL">Sierra Leone</option>
  <option value="SG">Singapore</option>
  <option value="SX">Sint Maarten (Dutch part)</option>
  <option value="SK">Slovakia</option>
  <option value="SI">Slovenia</option>
  <option value="SB">Solomon Islands</option>
  <option value="SO">Somalia</option>
  <option value="ZA">South Africa</option>
  <option value="GS">South Georgia and the South Sandwich Islands</option>
  <option value="SS">South Sudan</option>
  <option value="ES">Spain</option>
  <option value="LK">Sri Lanka</option>
  <option value="SD">Sudan</option>
  <option value="SR">Suriname</option>
  <option value="SJ">Svalbard and Jan Mayen</option>
  <option value="SZ">Swaziland</option>
  <option value="SE">Sweden</option>
  <option value="CH">Switzerland</option>
  <option value="SY">Syrian Arab Republic</option>
  <option value="TW">Taiwan, Province of China</option>
  <option value="TJ">Tajikistan</option>
  <option value="TZ">Tanzania, United Republic of</option>
  <option value="TH">Thailand</option>
  <option value="TL">Timor-Leste</option>
  <option value="TG">Togo</option>
  <option value="TK">Tokelau</option>
  <option value="TO">Tonga</option>
  <option value="TT">Trinidad and Tobago</option>
  <option value="TN">Tunisia</option>
  <option value="TR">Turkey</option>
  <option value="TM">Turkmenistan</option>
  <option value="TC">Turks and Caicos Islands</option>
  <option value="TV">Tuvalu</option>
  <option value="UG">Uganda</option>
  <option value="UA">Ukraine</option>
  <option value="AE">United Arab Emirates</option>
  <option value="GB">United Kingdom</option>
  <option value="US">United States</option>
  <option value="UM">United States Minor Outlying Islands</option>
  <option value="UY">Uruguay</option>
  <option value="UZ">Uzbekistan</option>
  <option value="VU">Vanuatu</option>
  <option value="VE">Venezuela, Bolivarian Republic of</option>
  <option value="VN">Viet Nam</option>
  <option value="VG">Virgin Islands, British</option>
  <option value="VI">Virgin Islands, U.S.</option>
  <option value="WF">Wallis and Futuna</option>
  <option value="EH">Western Sahara</option>
  <option value="YE">Yemen</option>
  <option value="ZM">Zambia</option>
  <option value="ZW">Zimbabwe</option>
</select>
         </div><br><br><br><br>

        &nbsp;&nbsp;&nbsp;
      <?php
         include "AntiBotCaptcha/abcaptcha.php";
         captcha_text_length(5);
         captcha_echo();
      ?>

       <br>
          &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="captcha" placeholder="อักขระในภาพ" required>
       <br><br>

        <div class="col-xs-12" >
              <font size="2">ห้ามโพสต์เนื้อหาใดๆ ที่คุณไม่ได้รับอนุญาตสิทธิ์</font><br>
              <input type="checkbox" name="accept">&nbsp;<strong>ยอมรับเงื่อนไขของ Mango</strong> <br>&nbsp;&nbsp;&nbsp;
         </div><br><br><br><br>

         <div class="col-xs-12" >
             <p style="text-align: center"><font size="4"><button>ดำเนินการต่อ</button><br class="clear"></font></p>
         </div>

      </form>
    </div>
    <!--container-->
</form>
  <p style="text-align: center"><a href="index2.php">กลับหน้าหลัก</a></p>
  </body>
</html>
