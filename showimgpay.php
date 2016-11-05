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
var fileCount = 1;

$(function() {

	fileCount = $('[type=file]').length;
	for(i = 1; i <= fileCount; i++) {
		$('#bt-upload' + i).click(function() {
			uploadFile();
		});
	}

function resetForm() {
	$('#form-pro')[0].reset();
	$('input:file').clearInputs();  //อยู่ในไลบรารี form.js
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
?>


<?php
//$field = "ทั้งหมด";
$sql = "SELECT * FROM images_pay";
$sql .= " ORDER BY imgpay_id DESC";
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
<?php 	echo "ใบแจ้งลำดับที่  $first - $last จาก $total  ($field)"; ?>
</caption>
<colgroup><col id="c1"><col id="c2"><col id="c3"><col id="c4"></colgroup>
<?php
include "lib/IMGallery/imgallery-no-jquery.php";
$row = $first;
while($pro = mysqli_fetch_array($result)) {
?>
<tr>
	<td><?php echo $row; ?></td>
    <td>
 	 <?php
		$sql = "SELECT * FROM images_pay WHERE imgpay_id = {$pro['imgpay_id']}";
		$r = mysqli_query($link, $sql);
		if(mysqli_num_rows($r) > 0)
		{
			echo "<br>";
			$src = "read-imagepay.php?id=";
			gallery_thumb_width(70);
			while($img =mysqli_fetch_array($r)) {
				gallery_echo_img($src . $img['imgpay_id']);
			}
		}
	?>
    </td>
</tr>
<?php
	$row++;
}
?>
</table>
<?php
	if(page_total() > 1) { 	 //ให้แสดงหมายเลขเพจเฉพาะเมื่อมีมากกว่า 1 เพจ
		echo '<p id="pagenum">';
		page_echo_pagenums();
		echo '</p>';
	}
?>

</article>
</body>
</html>
<?php mysqli_close($link);  ?>
