<?php
include "check-login.php";
 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Data Store</title>
<style>
	@import "global.css";
	#form-search {
		width: 750px;
		margin: auto;
	}
	div#search-col1 {
		display: inline-table;
		width: 300px;
	}
	div#search-col2 {
		display: inline-table;
		width: 400px;
	}
	#form-search [type=number] {
		width: 90px;
	}
	#form-search * {
		margin-bottom: 3px;
	}
	table {
		min-width: 840px;
	}
	caption {
		text-align: left;
		padding-bottom: 2px;
	}
	caption button {
		margin-left: 3px;
	}
	#c1 {
		width: 60px;
	}
	#c2 {
		width: 330px;
	}
	#c3 {
		width: 340px;
	}
	#c4 {
		width: 110px;
	}
	table th {
		background: green;
		color: yellow;
		padding: 5px;
		border: solid 1px white;
		font-size:12px;
	}
	tr:nth-of-type(odd) {
		background: #ddd;
	}
	tr:nth-of-type(even) {
		background: #ccf;
	}
	td {
		vertical-align: top;
		padding: 3px 0px 3px 5px;
		border: solid 1px white;
	}
	td:first-child, td:first-child {
		text-align: center;
	}
	td a:hover {
		color: red;
	}
	p#pagenum {
		width: 90%;
		text-align: center;
		margin: 5px;
	}
	#dialog {
		display: none;
		font-size: 14px !important;
	}
	#form-pro * {
		padding: 3px;
		margin-bottom: 3px;
	}
	[type=text],  [type=number], textarea, select {
		background: #eee;
		border: solid 1px gray;
	}
	#pro-name {
		width: 460px;
	}
	#detail {
		width: 460px;
		resize: none;
		overflow: auto;
		height: 60px;
	}
	#category {
		width: 158px ;
	}
	#supplier {
		width: 307px;
	}
	#price, .attr-name, span#propname {
		width: 150px;
		display: inline-block;
	}
	#quantity, .attr-value, span#propval {
		width: 300px;
	}
	span#propname, span#propval {
		margin-bottom: 0px !important;
	}
	.form-img {
		margin: 0px;
	}
	span.tag {
		width: auto;
		text-align: right;
		font-weight: bold;
		color: green;
		margin-right: 5px;
		display: inline-block;
	}
	.hidden {
		display: none;
	}
</style>
<link href="js/jquery-ui.min.css" rel="stylesheet">
<script src="js/jquery-2.1.1.min.js"> </script>
<script src="js/jquery-ui.min.js"> </script>
<script src="js/jquery.form.min.js"> </script>
<script src="js/jquery.blockUI.js"> </script>
<script>
var fileNo = 1;
var fileCount = 5;

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
<?php include "top.php"; ?>
<article>
<?php
include "dblink.php";
include "lib/pagination.php";

$sql = "SELECT * FROM categories";
$r_cat= mysqli_query($link, $sql);

$sql = "SELECT * FROM brands";
$r_bra= mysqli_query($link, $sql);

$sql = "SELECT sup_id, sup_name FROM suppliers";
$r_sup = mysqli_query($link, $sql);
?>


<?php
$field = "ทั้งหมด";
$sql = "SELECT products.*, categories.cat_name, brands.bra_name ,suppliers.sup_name
 			FROM products
			LEFT JOIN categories
			ON products.cat_id = categories.cat_id
      LEFT JOIN brands
			ON brands.bra_id = brands.bra_id
			LEFT JOIN suppliers
			ON products.sup_id = suppliers.sup_id";

if(($_GET['field'] == "price") && is_numeric($_GET['price_val'])) {
	$sql .= " WHERE price " . $_GET['price_op'] . " " . $_GET['price_val'];
	$field = "ราคา " . $_GET['price_op'] . " " . $_GET['price_val'];
}
else if(($_GET['field'] == "quantity") && is_numeric($_GET['quan_val'])) {
	$sql .= " WHERE quantity " . $_GET['quan_op'] . " " . $_GET['quan_val'];
	$field = "จำนวนที่มี " .  $_GET['quan_op'] . " " . $_GET['quan_val'];
}
else if(($_GET['field'] == "pro_name") && !empty($_GET['pro_key'])) {
	$sql .= " WHERE pro_name LIKE '%" . $_GET['pro_key'] . "%'";
	$field = "ชื่อสินค้า: '" .  $_GET['pro_key'] . "'";
}
else if($_GET['field'] == "category") {
	$sql .= " WHERE products.cat_id = " . $_GET['cat'];
	$field = "หมวดหมู่: " . $_GET['field_text'];
}
else if($_GET['field'] == "brand") {
	$sql .= " WHERE products.bra_id = " . $_GET['bra'];
	$field = "แบรนด์: " . $_GET['field_text'];
}
else if($_GET['field'] == "supplier") {
	$sql .= " WHERE products.sup_id = " . $_GET['sup'];
	$field = "ผู้จัดส่ง: "  . $_GET['field_text'];
}
$sql .= " ORDER BY pro_id DESC";
$result = page_query($link, $sql, 10);
$first = page_start_row();
$last = page_stop_row();
$total = page_total_rows();
if($total == 0) {
	$first = 0;
}
?>

<table border="0">
<caption>



<button id="bt-add-pro">เพิ่มสินค้า</button>
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"><col id="c4"></colgroup>
<?php
include "lib/IMGallery/imgallery-no-jquery.php";
while($pro = mysqli_fetch_array($result)) {
?>

<?php
}
?>
</table>

<div id="dialog">
<form id="form-pro">
<input type="text" name="pro_name" id="pro-name" placeholder="ชื่อสินค้า"><br>
<textarea name="detail" id="detail" placeholder="รายละเอียดของสินค้า"></textarea><br>
<input type="text" name="price" id="price" placeholder="ราคาต่อหน่วย">
<input type="text" name="quantity" id="quantity" placeholder="จำนวนสินค้า"><br>

<select name="category" id="category">
	<option>หมวดหมู่ของสินค้า</option>
    <?php
	mysqli_data_seek($r_cat, 0);
	while($cat = mysqli_fetch_array($r_cat)) {
		echo "<option value=\"{$cat['cat_id']}\">- {$cat['cat_name']}</option>";
	}
	?>
</select>


<select name="brand" id="brand">
	<option>แบรนด์ของสินค้า</option>
    <?php
	mysqli_data_seek($r_bra, 0);
	while($bra = mysqli_fetch_array($r_bra)) {
		echo "<option value=\"{$bra['bra_id']}\">- {$bra['bra_name']}</option>";
	}
	?>
</select>


<select name="supplier" id="supplier">
	<option>ผู้จัดส่งสินค้า (Supplier)</option>
    <?php
	mysqli_data_seek($r_sup, 0);
	while($sup = mysqli_fetch_array($r_sup)) {
		echo "<option value=\"{$sup['sup_id']}\">- {$sup['sup_name']}</option>";
	}
	?>
</select>


<br><br>
<span id="propname">คุณลักษณะสินค้า (เช่น สี)</span>
<span id="propval">ค่าของคุณลักษณะ (คั่นด้วย ","  เช่น ฟ้า, ขาว, แดง, ดำ)</span><br>
<input type="text" name="attr_name[]" class="attr-name" placeholder="ชื่อคุณลักษณะ (1)">
<input type="text" name="attr_value[]"  class="attr-value" placeholder="ค่าของคุณลักษณะ (1)"><br>
<input type="text" name="attr_name[]" class="attr-name" placeholder="ชื่อคุณลักษณะ (2)">
<input type="text" name="attr_value[]" class="attr-value" placeholder="ค่าของคุณลักษณะ (2)"><br>
<input type="text" name="attr_name[]" class="attr-name" placeholder="ชื่อคุณลักษณะ (3)">
<input type="text" name="attr_value[]" class="attr-value" placeholder="ค่าของคุณลักษณะ (3)"><br>
</form>
<br>

<form id="form-img1" method="post" action="product-image.php" enctype="multipart/form-data">
	ภาพสินค้า #1: <input type="file" name="file" id="file1">
    <button type="submit" id="bt-upload1" class="hidden">อัปโหลดภาพ</button>
</form>
<form id="form-img2" method="post" action="product-image.php" enctype="multipart/form-data">
	ภาพสินค้า #2: <input type="file" name="file" id="file2">
    <button type="submit" id="bt-upload2" class="hidden">อัปโหลดภาพ</button>
</form>
<form id="form-img3" method="post" action="product-image.php" enctype="multipart/form-data">
	ภาพสินค้า #3: <input type="file" name="file" id="file3">
    <button type="submit" id="bt-upload3" class="hidden">อัปโหลดภาพ</button>
</form>
<form id="form-img4" method="post" action="product-image.php" enctype="multipart/form-data">
	ภาพสินค้า #4: <input type="file" name="file" id="file4">
    <button type="submit" id="bt-upload4" class="hidden">อัปโหลดภาพ</button>
</form>
<form id="form-img5" method="post" action="product-image.php" enctype="multipart/form-data">
	ภาพสินค้า #5: <input type="file" name="file" id="file5">
    <button type="submit" id="bt-upload5" class="hidden">อัปโหลดภาพ</button>
</form>
<br>
<button type="button" id="bt-send">ส่งข้อมูล</button> (ภาพสินค้าจะใช้ภาพแรกเป็นภาพหลัก)
</div>
</article>
</body>
</html>
<?php mysqli_close($link);  ?>
