<?php
	$page = "ORDER MAKAN KARYAWAN";
	$makan = "";
	$confirm = "";
	include "koneksi.php";
	include "koneksihr.php";
	include "conn_hygiene.php";
	include "db_controller.php";
	include('connect_finger.php');
	// include('header.php');
	$target = ""; $ttfood =0; $ttfood10 =0; $ttfood12 =0; $ttfood14 =0; $ttfood18 =0; $ttfood22 =0; $ttfood02 =0;
	if(isset($_GET['day'])){ $headtgl = $_GET['day'];}else{	$headtgl=date('Y-m-d'); }
	$headtgl2 = date('Y-m-d', strtotime('+1 days', strtotime($headtgl)));
	$qweek = mysqli_query($konek,"SELECT * FROM `week_table` WHERE `tgl_awal` <= '$headtgl' AND `tgl_akhir` >= '$headtgl'"); $title=mysqli_fetch_array($qweek);
	$unit = isset($_GET['unit'])?$_GET['unit']:NULL;
	echo "<input type='hidden' value='".$headtgl."' id='harikerja' name='harikerja'/>";
	if($unit!=NULL){$sql = "SELECT * FROM karyawan WHERE unit ='$unit' ORDER BY unit, nama_karyawan";}else{
	$sql = "SELECT * FROM karyawan WHERE unit !='Other' ORDER BY unit, nama_karyawan";}
	$db_handle = new DBController();
	$posts = mysqli_query($konek, $sql);
	header("Content-type:application/vnd-ms-excel");
	header("Content-Disposition:attachment; filename=data_makan ".$headtgl.".xls");
?>
<?php
if(isset($_POST['confirm'])){
	$nik = isset($_POST['nik'])?$_POST['nik']:NULL;
	$tgl = isset($_POST['tgl'])?$_POST['tgl']:NULL;
	$m10 = isset($_POST['m10'])?$_POST['m10']:NULL;
	$m12 = isset($_POST['m12'])?$_POST['m12']:NULL;
	$m14 = isset($_POST['m14'])?$_POST['m14']:NULL;
	$m18 = isset($_POST['m18'])?$_POST['m18']:NULL;
	$m22 = isset($_POST['m22'])?$_POST['m22']:NULL;
	$m02 = isset($_POST['m02'])?$_POST['m02']:NULL;
	$ceksql = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order = '$tgl' AND nik_karyawan='$nik'"); $cek = mysqli_num_rows($ceksql);
	$sql = mysqli_query($konek,"INSERT INTO `order_makan`(`id_order`, `tgl_order`, `nik_karyawan`, `jam10`, `jam12`, `jam14`, `jam18`, `jam22`, `jam02`) 
	VALUES ('','$tgl','$nik','$m10','$m12','$m14','$m18','$m22','$m02')");
	if($sql&&$cek==0){
?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo "Order telah ter-konfirmasi !"; ?>
	</div>
<?php
	// header("Refresh:1; url=confirm_makan.php?day=$tgl");
}else{
		$up = mysqli_query($konek,"UPDATE `order_makan` SET `jam10` = '$m10', `jam12` = '$m12', `jam14` = '$m14', `jam18` = '$m18', `jam22` = '$m22', `jam02` = '$m02' WHERE tgl_order = '$tgl' AND nik_karyawan='$nik'; ");
?>
	<div class="alert alert-warning" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo "Data Order Berhasil di Update !"; ?>
	</div>
<?php
	// header("Refresh:1; url=confirm_makan.php?day=$tgl");
	} 
}
?>
<title>HRD | FID-TAA</title>

<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="plugins/select2/css/select2.css">
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="shortcut icon" href="assets/img/icbplogo.png" />
		<table border="1" id="" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th><center>NO</center></th>
                    <th><center>NIK</center></th>
                    <th><center>KARYAWAN</center></th>
                    <th><center>DEPARTEMEN</center></th>
                    <th><center>JAM 10</center></th>
                    <th><center>JAM 12</center></th>
                    <th><center>JAM 14</center></th>
                    <th><center>JAM 18</center></th>
                    <th><center>JAM 22</center></th>
                    <th><center>JAM 02</center></th>
                    <th><center>ORDER</center></th>
                    <th><center>ACTUAL</center></th>
                    <th><center>JAM FINGER</center></th>
				</tr>
			</thead>
			<tbody id="table-body">
			<?php $no =1; $tot10=0; $tot12=0; $tot14=0; $tot18=0; $tot22=0; $tot02=0; $totall=0;  $totact=0;
				while($record=mysqli_fetch_array($posts)){  $logtime=NULL;
					$nik = $record['nik'];
					$sqlorder = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order = '$headtgl' AND nik_karyawan='$nik'"); 
					$qkry = mysqli_query($konek,"SELECT * FROM karyawan WHERE nik='$nik'"); $dkry = mysqli_fetch_array($qkry);	
					$tgl1 = $headtgl." 06:00:00"; 	$tgl2 = $headtgl2." 06:00:00";	
					$resul1 = "SELECT [TimeLog] FROM [HITFPTA1].[dbo].[PersonalLog] WHERE [DateTime] BETWEEN '$tgl1' AND '$tgl2' AND FingerPrintID ='$dkry[kode_fg]' GROUP BY [TimeLog]";
					$fg_query = sqlsrv_query($connfinger, $resul1, array(), array( "Scrollable" => 'static' ));
					$fg = sqlsrv_query($connfinger, "SELECT CONVERT(varchar, [TimeLog]) AS loog  FROM [HITFPTA1].[dbo].[PersonalLog] WHERE [DateTime] BETWEEN '$tgl1' AND '$tgl2' AND FingerPrintID ='$dkry[kode_fg]'");
					$datafg=sqlsrv_num_rows($fg_query);
					while($datajam=sqlsrv_fetch_array($fg)){ 
						$logtime .= $datajam['loog'].", ";
					}
					$dray = substr($logtime,0,-2);
					// $dray2 = array_unique($dray);
					$order = mysqli_fetch_array($sqlorder);
					$getmenu10 = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$headtgl' AND jenis_menu='UTAMA' AND kode_menu = '$order[jam10]'"); $m10 = mysqli_fetch_array($getmenu10);
					$getmenu12 = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$headtgl' AND jenis_menu='UTAMA' AND kode_menu = '$order[jam12]'"); $m12 = mysqli_fetch_array($getmenu12);
					$getmenu14 = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$headtgl' AND jenis_menu='UTAMA' AND kode_menu = '$order[jam14]'"); $m14 = mysqli_fetch_array($getmenu14);
					$getmenu18 = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$headtgl' AND jenis_menu='UTAMA' AND kode_menu = '$order[jam18]'"); $m18 = mysqli_fetch_array($getmenu18);
					$getmenu22 = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$headtgl' AND jenis_menu='UTAMA' AND kode_menu = '$order[jam22]'"); $m22 = mysqli_fetch_array($getmenu22);
					$getmenu02 = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$headtgl' AND jenis_menu='UTAMA' AND kode_menu = '$order[jam02]'"); $m02 = mysqli_fetch_array($getmenu02);
					$ord=0; $or10=0; $or12=0; $or14=0; $or18=0; $or22=0; $or02=0;
					$aktual = number_format($datafg);
			?>
				<tr class="table-row" id="table-row-<?php echo $record['nik']; ?>">
					<td align="center" width="10"><?php echo $no++; ?></td>
					<td width="10"><center><?php echo $record['nik']; ?></center></td>
					<td><?php echo $record['nama_karyawan']; ?></td>
					<td width="10"><center><?php echo $record['unit']; ?></center></td>
					<td class="text-blue"><center><small><?php if($order['jam10']>0){echo $m10['judul_menu']; $or10++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam12']>0){echo $m12['judul_menu']; $or12++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam14']>0){echo $m14['judul_menu']; $or14++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam18']>0){echo $m18['judul_menu']; $or18++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam22']>0){echo $m22['judul_menu']; $or22++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam02']>0){echo $m02['judul_menu']; $or02++; $ord++;} ?></small></center></td>
					<td><center><small><?php if($ord>0){echo $ord;} ?></small></center></td>
					<td><center><small title="<?php echo $dray;?>"><?php if($aktual>0){echo $aktual;} ?></small></center></td>
					<td><small><?php if($aktual>0){echo $dray;} ?></small></td>
				</tr>
			<?php  $tot10+=$or10; $tot12+=$or12; $tot14+=$or14; $tot18+=$or18; $tot22+=$or22; $tot02+=$or02; $totall+=$ord; $totact+=$aktual; } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4"><center>TOTAL ORDER</center></th>
					<th><center><?php if($tot10>0){echo $tot10;} ?></center></th>
					<th><center><?php if($tot12>0){echo $tot12;} ?></center></th>
					<th><center><?php if($tot14>0){echo $tot14;} ?></center></th>
					<th><center><?php if($tot18>0){echo $tot18;} ?></center></th>
					<th><center><?php if($tot22>0){echo $tot22;} ?></center></th>
					<th><center><?php if($tot02>0){echo $tot02;} ?></center></th>
					<th><center><?php if($totall>0){echo $totall;} ?></center></th>
					<th><center><?php if($totact>0){echo $totact;} ?></center></th>
					<th><center></center></th>
			</tfoot>
		</table>
		</div>
	</div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="assets/jquery/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin.min.js"></script>
<script src="plugins/select2/js/select2.full.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/select2/js/select2.js"></script>
<script src="plugins/select2/js/select2.min.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script src="assets/datatables/jquery.dataTables.js"></script>
<script src="assets/datatables/dataTables.bootstrap4.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="js/demo/datatables-demo.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script>
	function deleteConfirm(url){
		$('#btn-delete').attr('href', url);
		$('#deleteModal').modal();
	}
	function confirmUsed(url){
		$('#btn-confirm').attr('href', url);
		$('#confirmModal').modal();
	}
	function rejectUsed(url){
		$('#btn-reject').attr('href', url);
		$('#rejectModal').modal();
	}
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
	function uploadspl(){
		var sppt = sppt;
		const link = 'spl_post.php';
			$.ajax({
				url: link,
				method: 'post',
				data: {sppt:sppt},
				success:function(data){
					$('#modal-default').modal("show");
					$('#tampil_modal').html(data);
					document.getElementById("judul").innerHTML='Upload Data SPL'; 
				}
            });
    }

function jam() {
var time = new Date(),
	hours = time.getHours(),
	minutes = time.getMinutes(),
	seconds = time.getSeconds();
document.querySelectorAll('.jam')[0].innerHTML = harold(hours) + " : " + harold(minutes) + " : " + harold(seconds);
	
function harold(standIn) {
	if (standIn < 10) {
		standIn = '0' + standIn
	}
	return standIn;
	}
}
setInterval(jam, 1000);
</script>
<script>
function changeday(){
		var tgl = $('#boxtgl').val();
        var url = "?day="+tgl;
        if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
}
var order = $('#sendfood').val(); $('#food').text(order+ " Porsi");
var order10 = $('#send10').val(); $('#food10').text(order10+ "");
var order12 = $('#send12').val(); $('#food12').text(order12+ "");
var order14 = $('#send14').val(); $('#food14').text(order14+ "");
var order18 = $('#send18').val(); $('#food18').text(order18+ "");
var order22 = $('#send22').val(); $('#food22').text(order22+ "");
var order02 = $('#send02').val(); $('#food02').text(order02+ "");
$(document).ready(function() {
    $('.display2').DataTable( {
        "aLengthMenu" : [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "iDisplayLength" : -1 ,
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
			function formatRibu(num){
				return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
			}
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
        }
    } );
} );
function getDay(){
	var url = $("#day").val();
	if (url) { // require a URL
		window.location = url; // redirect
	}
	return false;
}
function getunit(){
	var url = $("#unit").val();
	if (url) { // require a URL
		window.location = url; // redirect
	}
	return false;
}
function confirmorder(tgl){
var tanggal = tgl;
const link = 'popup_confirm.php';
	$.ajax({
		url: link,
		method: 'post',
		data: {tanggal:tanggal},
		success:function(data){
			$('#modal-default').modal("show");
			$('#tampil_modal').html(data);
			document.getElementById("judul").innerHTML='Confirm Order Makan '+ tanggal;
		}
	});
}

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
  var message = "Anda yakin ingin me-reset data yang dipilih ?";
  var checked = confirm(message);
  if(checked == true) {
   var selected_values = pegawai.join(",");
   $.ajax({
    type: "POST",
    url: "confirm_del.php",
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