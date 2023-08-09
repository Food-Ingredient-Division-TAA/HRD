<?php
ob_start();
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
} include('koneksi.php');?>
<form action="area.php" method="post" enctype="multipart/form-data" >
	<div class="form-group">
		<label>Kode Area *</label>
		<input class="form-control" required type="text" name="kode" placeholder=" Kode Area" />
	</div>
	<div class="form-group">
		<label>Nama Area *</label>
		<input class="form-control" required type="text" name="nama" placeholder="Nama Area" />
	</div>
	<div class="form-group">
		<label>Type Area *</label>
		<select class="form-control" name="type" required>
			<option value="">- SELECT -</option>
			<option value="STORAGE">STORAGE</option>
			<option value="PROSES">PROSES</option>
			<option value="PRODUKSI">PRODUKSI</option>
			<option value="OFFICE">OFFICE</option>
			<option value="MEETING">MEETING</option>
			<option value="REST">REST</option>
			<option value="OUTSIDE">OUTSIDE</option>
		<select>
	</div>
	<div class="form-group">
		<label>Dept Area *</label>
		<select class="form-control" name="unit" required>
			<option value="">- SELECT -</option>
			<option value="BUMBU">BUMBU</option>
			<option value="HR">HR</option>
			<option value="MINYAK">MINYAK</option>
			<option value="QC">QC</option>
			<option value="TEKNIK">TEKNIK</option>
			<option value="WH">WH</option>
			<option value="OTHER">OTHER</option>
		<select>
	</div>
	<div class="form-group">
		<label>Link Camera *</label>
		<input class="form-control" type="text" name="link" placeholder="Link Camera (Koordinasi Unit IT)" />
	</div>
	<span class="float-right">&nbsp;
		<input class="btn btn-success" type="submit" name="tambah" value="Save" />
	</span>
</form>