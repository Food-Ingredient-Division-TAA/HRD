<?php
ob_start();
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
} include('koneksi.php'); include('conn_hygiene.php');
	$id = $_POST['area'];
	$addquery = mysqli_query($hygiene_conn, "SELECT * FROM area WHERE id_area= '$id'");
	$data = mysqli_fetch_array($addquery);
?>
<form action="area.php" method="post" enctype="multipart/form-data" >
	<div class="form-group">
		<label>Kode Material *</label>
		<input class="form-control" required type="hidden" value="<?php echo $data['id_area']; ?>" name="id" placeholder=" Kode Material" />
		<input class="form-control" required type="text" value="<?php echo $data['kode_area']; ?>" name="kode" placeholder=" Kode Material" />
	</div>
	<div class="form-group">
		<label>Nama Area *</label>
		<input class="form-control" required type="text" value="<?php echo $data['nama_area']; ?>" name="nama" placeholder="Nama Area" />
	</div>
	<div class="form-group">
		<label>Type Area *</label>
		<select class="form-control" name="type" required>
			<option value="">- SELECT -</option>
			<option value="STORAGE" <?php if($data['type_area']=="STORAGE"): print "selected"; endif; ?>>STORAGE</option>
			<option value="PROSES" <?php if($data['type_area']=="PROSES"): print "selected"; endif; ?>>PROSES</option>
			<option value="PRODUKSI" <?php if($data['type_area']=="PRODUKSI"): print "selected"; endif; ?>>PRODUKSI</option>
			<option value="OFFICE" <?php if($data['type_area']=="OFFICE"): print "selected"; endif; ?>>OFFICE</option>
			<option value="MEETING" <?php if($data['type_area']=="MEETING"): print "selected"; endif; ?>>MEETING</option>
			<option value="REST" <?php if($data['type_area']=="REST"): print "selected"; endif; ?>>REST</option>
			<option value="OUTSIDE" <?php if($data['type_area']=="OUTSIDE"): print "selected"; endif; ?>>OUTSIDE</option>
		<select>
	</div>
	<div class="form-group">
		<label>Dept Area *</label>
		<select class="form-control" name="unit" required>
			<option value="">- SELECT -</option>
			<option value="BUMBU" <?php if($data['dept_area']=="BUMBU"): print "selected"; endif; ?>>BUMBU</option>
			<option value="HR" <?php if($data['dept_area']=="HR"): print "selected"; endif; ?>>HR</option>
			<option value="MINYAK" <?php if($data['dept_area']=="MINYAK"): print "selected"; endif; ?>>MINYAK</option>
			<option value="QC" <?php if($data['dept_area']=="QC"): print "selected"; endif; ?>>QC</option>
			<option value="TEKNIK" <?php if($data['dept_area']=="TEKNIK"): print "selected"; endif; ?>>TEKNIK</option>
			<option value="WH" <?php if($data['dept_area']=="WH"): print "selected"; endif; ?>>WH</option>
			<option value="OTHER" <?php if($data['dept_area']=="OTHER"): print "selected"; endif; ?>>OTHER</option>
		<select>
	</div>
	<div class="form-group">
		<label>Link Camera *</label>
		<input class="form-control" type="text" value="<?php echo $data['cam_area']; ?>" name="link" placeholder="Link Camera (Koordinasi Unit IT)" />
	</div>
	<span class="float-right">&nbsp;
		<input class="btn btn-success" type="submit" name="update" value="Save" />
	</span>
</form>