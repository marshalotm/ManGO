<html>
   <head>
     <link href="js/jquery-ui.min.css" rel="stylesheet">
     <script src="js/jquery-2.1.1.min.js"> </script>
     <script src="js/jquery-ui.min.js"> </script>
     <script src="js/jquery.form.min.js"> </script>
     <script src="js/jquery.blockUI.js"> </script>
     <script>
     $(function() {

     	$('a.more-detail, a.pro-name, a.pro-name-bestseller').click(function() {
     		var id = $(this).attr('data-id');
     		$.ajax({
     			type: 'post',
     			url: 'product-load.php',
     			data: {'id': id},
     			dataType: 'html',
     			beforeSend: function() {
     				$.blockUI({message:'<h3>กำลังโหลดข้อมูล...</h3>'});
     			},
     			success: function(result) {
     				$.unblockUI();
     				$('#dialog').html(result);
     				$('#dialog').dialog({
     					title: 'รายละเอียดสินค้า',
     					modal: true,
     					width: 'auto',
     					position: { my: "center top", at: "center top+70px", of: window}
     				});
     				$('.ui-dialog-titlebar-close').focus();
     			},
     			complete: function() {
     				$.unblockUI();
     			}
     		});
     	});

     	//ใช้ on() เพราะปุ่มในไดอะล็อกถูกโหลดมาทีหลังเพจ
     	$(document).on('click', 'button#dialog-add-cart', function() {
     		if(!$.isNumeric($('#dialog-quantity').val())) {
     			alert('กรุณาใส่จำนวนสินค้าเป็นตัวเลข');
     			return false;
     		}
     		var err = false;
     		$('#dialog select').each(function(index, value) {
     			if($(this).children('option:selected').index()==0) {  //ถ้าไม่ได้เลือกคุณลักษณะ
     				alert('กรุณาเลือก: ' + $(this).val());
     				err = true;
     				return false;
     			}
     		});

     		if(err) {
     			return;
     		}

     		$.ajax({
     			type: 'post',
     			url: 'cart-add.php',
     			data: $('#dialog-form').serializeArray(),
     			dataType: 'html',
     			beforeSend: function() {
     				$('#dialog').block({message:'<h3>กำลังหยิบใส่รถเข็น...</h3>'});
     			},
     			success: function(result) {
     				if(result.length > 0) {
     					$('#dialog').unblock();
     					alert(result);
     				}
     				else {
     				cartCount();
     				$('#dialog').block({message:'<h3>เพิ่มสินค้าในรถเข็นแล้ว...</h3>', timeout:2000, showOverlay:false,
     				 							css: {padding:'2px 20px', background:'#ffc', color:'green', width: 'auto'}});
     				}
     			}
     		});
     	});

     	$('button#order').click(function() {  //เมื่อคลิกปุ่มสั่งซื้อที่อยู่ตรงรถเข็น
     		location.href = "order-cart.php";
     	});

     	cartCount(); //ให้อ่านข้อมูลในรถเข็นมาแสดงทันทีที่เปิดเพจ (อาจเปิดไปเพจอื่นแล้วกลับมาที่หน้าหลักอีก)

     });

     function cartCount() {  //ฟังก์ชั่นสำหรับอ่านข้อมูลในรถเข็น
     	$.ajax({
     		type: 'post',
     		url: 'cart-count.php',
     		dataType: 'html',
     		success: function(result) {
     			$('#cart-count').html(result);
     		}
     	});
     }
     </script>
   </head>
 <body>
<?php
if($_GET['q']) {
	include "pagination.php";
  include "lib/IMGallery/imgallery-no-jquery.php";

	//$link = @mysqli_connect("localhost", "root", "abc456", "pmj")
 	//			or die(mysqli_connect_error()."</body></html>");
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

  //Algolithm
	$q =  trim($_GET['q']);
	$pat = "/[ ]{1,}/";
	$w = preg_split($pat, $q);


  //$title = $pro_name;
  //$content = $detail;

  //(title LIKE '%a%') OR (title LIKE '%b%) OR (title LIKE '%c%')
  $pro_name = array();
  foreach($w as $k) {
    $x = "(pro_name LIKE '%$k%')";  //เติมคำแทรกระหว่าง %...%
    array_push($pro_name, $x);
  }
  $pro_name = implode(" OR ", $pro_name);

  /*
  //(content LIKE '%a%') OR (content LIKE '%b%) OR (content LIKE '%c%')
  $content = array();
  foreach($w as $k) {
    $x = "(content LIKE '%$k%')";  //เติมคำแทรกระหว่าง %...%
    array_push($content, $x);
  }
  $content = implode(" OR ", $content);
  */


	//  (picture LIKE '%a%') OR (content LIKE '%b%) OR (content LIKE '%c%')
	//  $picture = array();
  //	foreach($w as $k) {
	//	$x = "(content LIKE '%$k%')";  //เติมคำแทรกระหว่าง %...%
	//	array_push($picture, $x);
	//  }

	//$picture = implode(" OR ", $picture);

 //$condition = "$title OR $content OR $picture";  //(title LIKE '%a%') ... OR (content LIKE '%b%) ...
  //$condition = "$title OR $content";
  $condition = "$pro_name";


	$sql = "SELECT * FROM products WHERE $condition";		//echo $sql;
	$rs = page_query($link, $sql, 5);




	echo "ค้นหา:  " . stripslashes($_GET['q']);

	$first = page_start_row();
	$last = page_stop_row();
	$total = page_total_rows();
	if($total == 0) {
		$first = 0;
	}



 	echo "<span id=\"result\">  ผลลัพธ์ที่: $first - $last จากทั้งหมด $total </span><br><br>";



   //$pic = 123;
	//ต่อไปเป็นขั้นตอนการทำให้คีย์เวิร์ดเป็นตัวหนา ใช้หลักการตามที่เราเคยทำในบทที่ 7
	//ขั้นแรกนำคีย์เวิร์ดแต่ละคำมาเชื่อมโยงด้วย "|" เพื่อให้แต่ละคำคือ 1 แพตเทิร์น (a|b|c)
	$p = implode("|", $w);
	$p = "/$p/i";
	while($data = mysqli_fetch_array($rs)) {
		//เปลี่ยนคีย์เวิร์ดแต่ละคำใน title และ content ให้เป็นตัวหนา
		$pro_name = htmlspecialchars($data['pro_name']);
		//$cont = htmlspecialchars($data['content']);
		$pro_name = preg_replace($p, "<b>\\0</b>", $pro_name);
		//$cont = preg_replace($p, "<b>\\0</b>", $cont);
    //$pic  = $data['picture'];
    $id =  $data['pro_id'];
 	  $src = "read-image3.php?pro_id=" . $data['pro_id'];



		//แสดงผลการสืบค้น
		//echo "<br><br><a href=\"{$data['url']}\" target=\"_blank\">$pro_name</a>";
    echo "<br><br><a href=# class=\"pro-name\" data-id=\"$id\">$pro_name</a>";
    //<a href=# class=\"pro-name\" data-id=\"$id\">
    echo "<br>";
    gallery_echo_img($src);
		//echo "<br><span class=\"desc\">$cont</span>";
		//echo "<span class=\"url\">{$data['url']}</span>";
	  //echo "<br><span class=\"desc\">$pic</span>";
		//echo "<br><span class=\"desc\"></span>";
		//echo '<br><img src="'.$pic.'" alt="HTML5 Icon" style="width:128px;height:128px">';


  }

	//ต่อไปให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
	if(page_total() > 1) {
		echo '<p id="pagenum">';
		page_echo_pagenums();
		echo '</p>';
	  }
	mysqli_close($link);
}
//else {
	//echo '<h3>ค้นหาข้อมูลสินค้า</h3>';
//}


?>
  </body>
</html>
<?php mysqli_close($link); ?>
