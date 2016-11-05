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
<?php
include "dblink.php";

?>

<form id="form-img1" method="post" action="uploadpayaction.php" enctype="multipart/form-data">
	ภาพสินค้า #1: <input type="file" name="file" id="file1">
    <button type="submit" id="bt-upload1" class="hidden">อัปโหลดภาพ</button>
</form>

<br>
<button type="button" id="bt-send">ส่งข้อมูล</button>
</div>
</article>
</body>
</html>
<?php mysqli_close($link);  ?>
