<?php
ob_start();
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
} include('koneksihr.php');?>
<form action="spl_upload.php" method="post" enctype="multipart/form-data" >
	<div class="form-group" id="inpost">
		<input class="form-control" style="text-transform:uppercase" required type="file" name="template" placeholder="Material" />
	</div>
	<span class="float-right" id="btnpost">&nbsp;
		<input class="btn btn-success" onclick="procesUpload();" type="submit" name="upload" value="Upload" />
	</span>
	<div class="progress" id="progres"><i id="progresbar" class="progress-bar progress-bar-primary progress-bar-striped progress-bar-animated"></i></div>
</form>
<script>
	$('#progresbar').css("width","0%");
	$('#progres').css("height","25px");
	$('#progres').css("display","none");
function procesUpload() {
  $('#inpost').css("display","none");
  $('#btnpost').css("display","none");
$('#progres').css("display","");
$('#progresbar').css("width","0%");
$('#progresbar').css("width","100%");
$('#progresbar').text("100%");
}
</script>