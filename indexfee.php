<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mango store</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    include "dblink.php";
 ?>


<!--top bar --->
<?php
   include "topbar.php";
   include "lib/pagination.php";
//<!-- End top bar --->
?>


</td>
<td id="td-content"><br>
<?php
$field = "ทั้งหมด";
$sql = "SELECT *  FROM products ";
if(isset($_GET['catid']) && !empty($_GET['catid'])) {
	$cat_id  = $_GET['catid'];
	$sql .= "WHERE cat_id  = '$cat_id' ";
	$field = $_GET['catname'];
}

if(isset($_GET['braid']) && !empty($_GET['braid'])) {
	$bra_id  = $_GET['braid'];
	$sql .= "WHERE bra_id  = '$bra_id' ";
	$field = $_GET['braname'];
}

$sql .= "ORDER BY pro_id DESC";
$result = page_query($link, $sql, 10);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}
 	echo "รายการสินค้า: $field  (ลำดับที่  $first - $last จาก $total)";

?>

<!--PHP + HTML output--->
<br>
<br>
<br>
<br>



<?php
$sql = "SELECT * FROM categories LIMIT 20";
$r = mysqli_query($link, $sql);
$self = $_SERVER['PHP_SELF'];
$h = $self . "?catid=";
echo "<a href=\"$h\" class=\"category\"><li>ทั้งหมด</li></a>";
while($cat = mysqli_fetch_array($r)) {
	$h = $self . "?catid=" . $cat['cat_id'] . "&catname=" . $cat['cat_name'];
	echo "<a href=\"$h\" class=\"category\"><li>". $cat['cat_name'] . "</li></a>";
}
?>

<br>
<br>

<td id="td-aside-left">
<span id="bra-name">แบรนด์สินค้า</span>
<?php
$sql = "SELECT * FROM brands LIMIT 20";
$rb = mysqli_query($link, $sql);
$self2 = $_SERVER['PHP_SELF'];
$h2 = $self2 . "?braid=";
while($bra = mysqli_fetch_array($rb)) {
	$h2 = $self2 . "?braid=" . $bra['bra_id'] . "&braname=" . $bra['bra_name'];
	echo "<a href=\"$h2\" class=\"brand\"><li>". $bra['bra_name'] . "</li></a>";
}
?>



<br>
<br>

<?php
include "lib/IMGallery/imgallery-no-jquery.php";
while($pro = mysqli_fetch_array($result)) {
	 $id =  $pro['pro_id'];
	 $src = "read-image.php?pro_id=" . $pro['pro_id'];
 ?>
<section class="section-pro">
	<div class="div-img"><?php gallery_echo_img($src); ?></div>
    <div class="div-summary">
    <?php
		echo "<a href=# class=\"pro-name\" data-id=\"$id\">". $pro['pro_name'] . "</a><br>";
    	echo mb_substr($pro['detail'], 0, 50, 'utf-8') . "...<br>";

		echo "<a href=# class=\"more-detail\" data-id=\"$id\">รายละเอียด &raquo;</a>";
		echo  "<span class=\"price\">ราคา: " . number_format($pro['price']) . "</span>";
	?>
    </div>
</section>
<?php
}
?>
<br class="clear">

<?php
	if(page_total() > 1) { 	 //ให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
		echo '<div id="pagenum">';
		page_echo_pagenums();
		echo '</div>';
	}
?>

<br>
<br>

<tr>
  <td colspan="3" id="td-footer">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&copy; <?php echo date('Y'); ?> Mango | store TH - <a href="admin_data.php">Administrator</a></td>
</tr>

 </body>
</html>
<?php mysqli_close($link);  ?>
