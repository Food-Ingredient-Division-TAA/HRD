<?php
	$page = "LIST AREA";
	$master = "";
	$area = "";
	include('header.php');
?>
<?php
if(isset($_POST['pwg_id'])) {
 $pwg_id = trim($_POST['pwg_id']);
 $sql = "DELETE FROM area WHERE id_area in ($pwg_id)";
 $resultset = mysqli_query($hygiene_conn, $sql) or die("database error:". mysqli_error($hygiene_conn));
?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo " Data berhasil di hapus !"; ?>
	</div>
<?php
}
?>
<?php if(isset($_GET['berhasil'])){ ?>
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $_GET['berhasil']." data area berhasil di record !"; ?>
</div>
<?php }else{NULL;} ?>
<?php
if(isset($_GET['hps'])){
	$id = isset($_GET['hps'])?$_GET['hps']:NULL;
	$delquery = mysqli_query($hygiene_conn, "DELETE FROM area WHERE id_area = '$id'");
	if($delquery){
?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo " Data berhasil di hapus !"; ?>
	</div>
<?php
	header("Refresh:1; url=area.php");}else{header("Refresh:1; url=area.php");}
}
?>
<?php 
	if(isset($_POST['tambah'])){
		$kode = isset($_POST['kode'])?$_POST['kode']:NULL;
		$nama = isset($_POST['nama'])?$_POST['nama']:NULL;
		$type = isset($_POST['type'])?$_POST['type']:NULL;
		$unit = isset($_POST['unit'])?$_POST['unit']:NULL;
		$link = isset($_POST['link'])?$_POST['link']:NULL;
		$inquery = mysqli_query($hygiene_conn, "INSERT INTO `area`(`id_area`, `kode_area`, `nama_area`, `type_area`, `dept_area`, `cam_area`, `status`) 
		VALUES ('','$kode','$nama','$type','$unit','$link','0')");
		if($inquery){
?>		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo " Data Area berhasil tambahkan !"; ?>
		</div>
		<?php	header("Refresh:1; url=area.php");}else{header("Refresh:1; url=area.php");}
	}
?>
<?php 
	if(isset($_POST['update'])){
		$id = isset($_POST['id'])?$_POST['id']:NULL;
		$kode = isset($_POST['kode'])?$_POST['kode']:NULL;
		$nama = isset($_POST['nama'])?$_POST['nama']:NULL;
		$type = isset($_POST['type'])?$_POST['type']:NULL;
		$unit = isset($_POST['unit'])?$_POST['unit']:NULL;
		$link = isset($_POST['link'])?$_POST['link']:NULL;
		$upquery = mysqli_query($hygiene_conn, "UPDATE area SET kode_area ='$kode',nama_area='$nama',type_area='$type', dept_area='$unit',cam_area='$link' WHERE id_area='$id'");
		if($upquery){
?>		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo " Data Area berhasil Diubah !"; ?>
		</div>
<?php	header("Refresh:1; url=area.php");}else{header("Refresh:1; url=area.php");}
	}
?>

<div class="card">
	<div class="card-header">
			<span class="float-right">&nbsp;
			<a title="Tambah Area" onclick="addArea()" class="btn btn-success btn-sm float-right" href="#!"><i class="fas fa-plus-circle"> New</i></a>
			</span>
			<span class="float-right">&nbsp;
			<a title="Upload List Area" onclick="uploadarea()" class="btn btn-primary btn-sm float-right" href="#!"><i class="fas fa-upload"> Upload</i></a>
			</span>
			<span class="float-right">&nbsp;
			<a title="Download Template Area" class="btn btn-warning btn-sm float-right" href="tmp_area.xls"><i class="fa fa-file-excel"> Template</i></a>
			</span>
	</div>			
	<div class="card-body">
		<div class="table-responsive">
		<table id="dataTable" class="table table-striped table-bordered table-sm table-hover tableFixHead" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th width="60"><center>NO</center></th>
                    <th><center>KODE</center></th>
                    <th><center>AREA</center></th>
                    <th><center>TYPE</center></th>
                    <th><center>UNIT</center></th>
                    <th><center>CAM</center></th>
					<th width="60"><center><a title="Delete" id="hapus_record" href="#!" class="btn-sm text-red"> <i class="fas fa-trash-alt"></i></a>
					<input type="checkbox" onchange="checkAll(this)" name="chk[]" id="pilih_semua"><span class="baris_dipilih" id="jumlah_pilih"> 0</span></center></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = mysqli_query($hygiene_conn, "SELECT * FROM area ORDER BY kode_area ASC");
				$no = 1;
				while($data=mysqli_fetch_array($sql)){
				?>
				<tr id="<?php echo $data['id_area']; ?>">
					<td align="center"><?php echo $no; ?></td>
					<td align="center"><?php echo $data['kode_area'];?></td>
					<td><?php echo $data['nama_area']; ?></td>
					<td align="center"><?php echo $data['type_area']; ?></td>
					<td align="center"><?php echo $data['dept_area']; ?></td>
				<td align="center"><?php if($data['cam_area']!=""){ ?><a href="<?php echo $data['cam_area']; ?>" target="blank" class="btn-sm btn-primary" onclick="gonCam('<?php echo $data['cam_area']; ?>', '<?php echo $data['nama_area']; ?>');"><small><i class="fa fa-video"></i>&nbsp; Cam</small></a><?php }?></td>
					<td align="center" width="10">
					<a title="Update" onclick="editArea('<?php echo $data['id_area'];?>')" href="#!" class="btn-sm text-yellow"><i class="fas fa-edit"></i></a>
					<input type="checkbox" class="pgw_checkbox" data-pwg-id="<?php echo $data["id_area"]; ?>"></td>
				</tr>
			<?php
			$no++;
			 }?>
			<tbody>
			<tfoot>
			</tfoot>
		</table>
		</div>
	</div>
</div>

<?php
	include('footer.php');
?>

 <script type="text/javascript">

function onCam(url, place){
var kode = url;
var area = place;
const link = kode;
	$.ajax({
		url: link,
		method: 'post',
		data: {kode:kode, area:area},
		success:function(data){
			$('#modal-detail').modal("show");
			$('#data_modal').html(data);
			document.getElementById("heading").innerHTML=area; 
		}
	});
}
function uploadarea(){
	var area = area;
	const link = 'area_upload.php';
		$.ajax({
			url: link,
			method: 'post',
			data: {area:area},
			success:function(data){
				$('#modal-default').modal("show");
				$('#tampil_modal').html(data);
				document.getElementById("judul").innerHTML='Uplad list Area'; 
			}
		});
}
function addArea(){
	var area = area;
	const link = 'area_add.php';
		$.ajax({
			url: link,
			method: 'post',
			data: {area:area},
			success:function(data){
				$('#modal-default').modal("show");
				$('#tampil_modal').html(data);
				document.getElementById("judul").innerHTML='Add Area'; 
			}
		});
}
function editArea(id){
	var area = id;
	const link = 'area_edit.php';
		$.ajax({
			url: link,
			method: 'post',
			data: {area:area},
			success:function(data){
				$('#modal-default').modal("show");
				$('#tampil_modal').html(data);
				document.getElementById("judul").innerHTML='Edit Area'; 
			}
		});
}
 $(document).ready(function() {
    $('#scroll').dataTable( {
        "scrollY": 200,
        "scrollX": true
    } );
} );
</script>
<script type="text/javascript">
  jQuery('#pilih_semua').on('click', function(e) {
 if($(this).is(':checked',true)) {
  $(".pgw_checkbox").prop('checked', true);
 }
 else {
  $(".pgw_checkbox").prop('checked',false);
 }
 // mengatur semua jumlah checkbox yang dicentang
 $("#jumlah_pilih").html($("input.pgw_checkbox:checked").length);
});
// mengatur jumlah checkbox tertentu yang dicentang
$(".pgw_checkbox").on('click', function(e) {
 $("#jumlah_pilih").html($("input.pgw_checkbox:checked").length);
});

jQuery('#hapus_record').on('click', function(e) {
 var pegawai = [];
 $(".pgw_checkbox:checked").each(function() {
  pegawai.push($(this).data('pwg-id'));
 });
 if(pegawai.length <=0)  {
  alert("Anda Belum Memilih data.");
 }
 else {
  var message = "Anda yakin ingin menghapus record yang dipilih ?";
  var checked = confirm(message);
  if(checked == true) {
   var selected_values = pegawai.join(",");
   $.ajax({
    type: "POST",
    url: "area_del.php",
    cache:false,
    data: 'pwg_id='+selected_values,
    success: function(response) {
     // menghilangkan baris pegawai yang dihapus
     var pgw_ids = response.split(",");
     for (var i=0; i<pgw_ids.length; i++ ) {
	//   $("#"+pgw_ids[i]).remove();
	  location.reload();
     }
    }
   });
  }
 }
});
 </script>