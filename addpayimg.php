<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Data Store</title>
<style>
	@import "global.css";

	.form-img {
		margin: 0px;
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
<!--- HTML ---->

<!--- insert picture --->
<form id="form-img1" method="post" action="uploadpayaction.php" enctype="multipart/form-data">
	   <font size="2">หลักฐานการโอน [ไฟล์ jpg,gif,png,pdf ไม่เกิน2MB]</font> : <input type="file" name="file" id="file1">
    <button type="submit" id="bt-upload1" class="hidden">อัปโหลดภาพ</button>
</form>

<br>
<button type="button" id="bt-send">อัพโหลดรูปภาพ</button>
</body>
</html>
<?php mysqli_close($link);  ?>
