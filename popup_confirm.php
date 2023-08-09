<?php
 include('koneksi.php');
$tgl = $_POST['tanggal'];
$tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl)));
$deth1 = $tgl2." 16:00:00";
$deth2 = $tgl." 09:00:00";
if($deth1<=date('Y-m-d H:i:s')){ $sel = "disabled";}else{ $sel=NULL;}
if($deth2<=date('Y-m-d H:i:s')){ $sel2 = "disabled";}else{ $sel2=NULL;}
?>
<form action="confirm_makan.php" method="post" enctype="multipart/form-data">	
		<label>JAM 10:00, 12:00 => </label> Close Order (H-1) Pukul 16:00 WIB <br/>
		<label>JAM 18:00, 22:00, 02:00 => </label> Close Order (H) Pukul 09:00 WIB <br/>
		<label>NASI : </label>
    <div class="form-inline">
	<?php $qmenu = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='WAJIB' ORDER BY kode_menu ASC");
	while($dmenu=mysqli_fetch_array($qmenu)){
	?>
		<i><?php echo $dmenu['kode_menu'].")".$dmenu['judul_menu'].";"; ?> &nbsp; &nbsp;</i>
	<?php } ?>
    </div>
		<!-- <label>MENU (Utama): </label>
    <div class="form-inline">
	<?php $qmenu = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' ORDER BY kode_menu ASC");
	while($dmenu=mysqli_fetch_array($qmenu)){
	?>
		<i><?php echo $dmenu['kode_menu'].")".$dmenu['judul_menu'].";"; ?> &nbsp; &nbsp;</i>
	<?php } ?>
    </div> -->
		<label>MENU (Sampingan): </label>
    <div class="form-inline">
	<?php 
	$qmenu = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='TAMBAHAN' AND quota_menu > 0 ORDER BY kode_menu ASC");
	while($dmenu=mysqli_fetch_array($qmenu)){
	?>
		<i><?php echo $dmenu['kode_menu'].")".$dmenu['judul_menu'].";"; ?> &nbsp; &nbsp;</i>
	<?php } ?>
    </div><br/>
	<div class="form-group">
		<select onchange="getnik();" class="form-control-sm" style="width:100%;" id="nik" name="nik" required>
			<option value="">------ * NAMA KARYAWAN * ------</option> -->
        <?php $option=mysqli_query($konek,"SELECT * FROM karyawan WHERE unit!='Other' ORDER BY nama_karyawan ASC"); 
        while($get=mysqli_fetch_array($option)){?>
          <option value="<?php echo $get['nik']; ?>"><?php echo $get['nama_karyawan']; ?></option>
        <?php } ?>
		<select> 
		<!-- <input class="form-control" type="number" title="NIK Karyawan" placeholder="NIK Karyawan" min="1000000" max="99999999" id="nik" name="nik" required/> -->
	</div>	
	<div class="form-group">
    <input class="form-control" type="hidden" placeholder="tanggal" value="<?php echo $_POST['tanggal']; ?>" name="tgl" required/> 
		<div class="form-inline">
			<input class="btn btn-default" width="10%" value="JAM 10:00" />
			<select class="form-control"  id="m10" name="m10" required>
				<option value="0">------ * MENU * ------</option> -->
			<?php 
			$opti10=mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND kode_menu <= 4 ORDER BY kode_menu ASC"); 
			while($get10=mysqli_fetch_array($opti10)){ 
				$order10 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam10='$get10[kode_menu]'"); $po10 = mysqli_num_rows($order10);
				if($po10<$get10['quota_menu']){
			?>
			<option value="<?php echo $get10['kode_menu']; ?>"><?php echo $get10['kode_menu'].". ".$get10['judul_menu']; ?></option>
			<?php } }?>
			<select> 
			<!-- <input class="form-control" type="number" title="Order Makan Jam 10:00" placeholder="10:00" min="0" id="m10" name="m10" required/> -->
		</div>
	</div>
	<div class="form-group">
		<div class="form-inline">
			<input class="btn btn-default" width="10%" value="JAM 12:00" />
			<select class="form-control"  id="m12" name="m12" required>
				<option value="0">------ * MENU * ------</option> -->
			<?php $opti12=mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND kode_menu BETWEEN 5 AND 8 ORDER BY kode_menu ASC"); 
			while($get12=mysqli_fetch_array($opti12)){
				$order12 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam12='$get12[kode_menu]'"); $po12 = mysqli_num_rows($order12);
				if($po12<$get12['quota_menu']){
			?>
			<option value="<?php echo $get12['kode_menu']; ?>"><?php echo $get12['kode_menu'].". ".$get12['judul_menu']; ?></option>
			<?php } } ?>
			<select> 
			<!-- <input class="form-control" type="number" title="Order Makan Jam 12:00" placeholder="12:00" min="0" id="m12" name="m12" required/> -->
		</div>
	</div>
	<div class="form-group">
		<div class="form-inline">
			<input class="btn btn-default" width="10%" value="JAM 18:00" />
			<select class="form-control"  id="m18" name="m18" required>
				<option value="0">------ * MENU * ------</option> -->
			<?php $opti18=mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND kode_menu BETWEEN 13 AND 16 ORDER BY kode_menu ASC"); 
			while($get18=mysqli_fetch_array($opti18)){
				$order18 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam18='$get18[kode_menu]'"); $po18 = mysqli_num_rows($order18);
				if($po18<$get18['quota_menu']){
			?>
			<option value="<?php echo $get18['kode_menu']; ?>"><?php echo $get18['kode_menu'].". ".$get18['judul_menu']; ?></option>
			<?php } } ?>
			<select> 
			<!-- <input class="form-control" type="number" title="Order Makan Jam 18:00" placeholder="18:00" min="0" id="m18" name="m18" required/> -->
		</div>
	</div>
	<div class="form-group">
		<div class="form-inline">
			<input class="btn btn-default" width="10%" value="JAM 22:00" />
			<select class="form-control"  id="m22" name="m22" required>
				<option value="0">------ * MENU * ------</option> -->
			<?php $opti22=mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND kode_menu BETWEEN 17 AND 20 ORDER BY kode_menu ASC"); 
			while($get22=mysqli_fetch_array($opti22)){
				$order22 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam22='$get22[kode_menu]'"); $po22 = mysqli_num_rows($order22);
				if($po22<$get22['quota_menu']){
			?>
			<option value="<?php echo $get22['kode_menu']; ?>"><?php echo $get22['kode_menu'].". ".$get22['judul_menu']; ?></option>
			<?php } } ?>
			<select> 
			<!-- <input class="form-control" type="number" title="Order Makan Jam 22:00" placeholder="22:00" min="0" id="m22" name="m22" required/> -->
		</div>
	</div>
	<div class="form-group">
		<div class="form-inline">
			<input class="btn btn-default" width="10%" value="JAM 02:00" />
			<select class="form-control"  id="m02" name="m02" required>
				<option value="0">------ * MENU * ------</option> -->
			<?php $opti02=mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND kode_menu BETWEEN 21 AND 26 ORDER BY kode_menu ASC"); 
			while($get02=mysqli_fetch_array($opti02)){
				$order02 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam02='$get02[kode_menu]'"); $po02 = mysqli_num_rows($order02);
				if($po02<$get02['quota_menu']){
			?>
			<option value="<?php echo $get02['kode_menu']; ?>"><?php echo $get02['kode_menu'].". ".$get02['judul_menu']; ?></option>
			<?php } } ?>
			<select> 
			<!-- <input class="form-control" type="number" title="Order Makan Jam 02:00" placeholder="02:00" min="0" id="m02" name="m02" required/> -->
		</div>
	</div>
	<span class="float-right">&nbsp;
		<input class="btn btn-success" type="submit" name="confirm" value="Confirm" />
	</span>
</form>

<script type="text/javascript">
 $(document).ready(function () {
      $('#nik').select2({
          sortField: 'text'
      });
  });
function getnik(){
  $('#m10').val('0');
  $('#m12').val('0');
  $('#m14').val('0');
  $('#m18').val('0');
  $('#m22').val('0');
  $('#m02').val('0');
}
</script>