<?php
ob_start();
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
} include('koneksi.php');?>
<form action="area_aksi.php" method="post" enctype="multipart/form-data" >
	<div class="form-group">
		<input class="form-control" style="text-transform:uppercase" required type="file" name="template" placeholder="Material" />
	</div>
	<span class="float-right">&nbsp;
		<input class="btn btn-success" type="submit" name="simpan" value="Upload" />
	</span>
</form>