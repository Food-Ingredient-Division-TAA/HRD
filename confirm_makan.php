<?php
	$page = "ORDER MAKAN KARYAWAN";
	$makan = "";
	$confirm = "";
	include('connect_finger.php');
	include('header.php');
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
	$uptime = date('Y-m-d H:i:s');
	$ceksql = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order = '$tgl' AND nik_karyawan='$nik'"); $cek = mysqli_num_rows($ceksql);
	if($cek==0){
		$sql = mysqli_query($konek,"INSERT INTO `order_makan`(`id_order`, `tgl_order`, `nik_karyawan`, `jam10`, `jam12`, `jam14`, `jam18`, `jam22`, `jam02`, `uporder`) 
		VALUES ('','$tgl','$nik','$m10','$m12','$m14','$m18','$m22','$m02','$uptime')");
?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo "Order telah ter-konfirmasi !"; ?>
	</div>
<?php
	// header("Refresh:1; url=confirm_makan.php?day=$tgl");
}else{
		$up = mysqli_query($konek,"UPDATE `order_makan` SET `jam10` = '$m10', `jam12` = '$m12', `jam14` = '$m14', `jam18` = '$m18', `jam22` = '$m22', `jam02` = '$m02', `uporder` = '$uptime' WHERE tgl_order = '$tgl' AND nik_karyawan='$nik'; ");
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
<div class="card">
	<div class="card-header">
			<span class="float-right">&nbsp;
			<a title="Save & Reload" class="btn btn-primary btn-sm float-right" href=""><i class="fas fa-sync"></i></a>
			</span>
			<span class="float-right">&nbsp;
			<a title="Print Jadwal Manpower Pdf" class="btn btn-info btn-sm float-right" target="blank" href="manpowerpdf.php?week=<?php echo $title['title_week'];?>&shift=<?php echo $shif; ?>&area=<?php echo $area; ?>"><i class="fas fa-file-pdf"></i></a>
			</span>&nbsp;
			<span class="float-right">&nbsp;
			<a title="Print Jadwal Manpower Excel" class="btn btn-warning btn-sm float-right" target="blank" href="makanxls.php?day=<?php echo $headtgl;?>&unit=<?php echo $unit;?>"><i class="fas fa-file-excel"></i></a>
			</span>&nbsp;
			<span class="float-right">&nbsp;
			<h3 class="card-title">
				<select onChange="getunit()" class="form-control-sm" id="unit" name="unit">
					<option value="?unit=&day=<?php echo $headtgl;?>" <?php if($unit=="1A"){ echo "selected";}?>>-ALL DEPARTEMEN-</option>
					<option value="?unit=Bumbu&day=<?php echo $headtgl;?>" <?php if($unit=="Bumbu"){ echo "selected";}?>>BUMBU</option>
					<option value="?unit=Minyak&day=<?php echo $headtgl;?>" <?php if($unit=="Minyak"){ echo "selected";}?>>MINYAK</option>
					<option value="?unit=Warehouse&day=<?php echo $headtgl;?>" <?php if($unit=="Warehouse"){ echo "selected";}?>>WH</option>
					<option value="?unit=Teknik&day=<?php echo $headtgl;?>" <?php if($unit=="Teknik"){ echo "selected";}?>>TEKNIK</option>
					<option value="?unit=QC&day=<?php echo $headtgl;?>" <?php if($unit=="QC"){ echo "selected";}?>>QC</option>
					<option value="?unit=HR&day=<?php echo $headtgl;?>" <?php if($unit=="HR"){ echo "selected";}?>>HR</option>
					<option value="?unit=Akunting&day=<?php echo $headtgl;?>" <?php if($unit=="Akunting"){ echo "selected";}?>>ACCOUNT</option>
					<option value="?unit=PPIC&day=<?php echo $headtgl;?>" <?php if($unit=="PPIC"){ echo "selected";}?>>PPIC</option>
					<option value="?unit=Purchasing&day=<?php echo $headtgl;?>" <?php if($unit=="Purchasing"){ echo "selected";}?>>PURCHASE</option>
					<option value="?unit=MFG&day=<?php echo $headtgl;?>" <?php if($unit=="MFG"){ echo "selected";}?>>MANUFACTURING</option>
				</select>
			</h3>
			</span>&nbsp;
		<h3 class="card-title">
		<?php date_default_timezone_set('Asia/Jakarta');
		 $back = date('Y-m-d', strtotime('-1 days', strtotime($headtgl))); $next = date('Y-m-d', strtotime('+1 days', strtotime($headtgl)));?>
			<!-- <a title="<?php echo format_indo($back); ?>" class="btn btn-default btn-sm" href="?day=<?php echo $back; ?>"><li class="fas fa-angle-double-left "></li> Prev </a> 
			<a class="btn btn-default btn-sm" href="#!"><strong> <?php echo format_indo($headtgl); ?> </strong></a>
			<a class="btn btn-default btn-sm" title="<?php echo format_indo($next);?>" href="?day=<?php echo $next; ?>">  Next <li class="fas fa-angle-double-right "></li></a> -->
			<input onchange="changeday();" class="form-control-sm" id="boxtgl" type="date" value="<?php echo $headtgl; ?>"/> 
		</h3>
		<span>
			<a title="Food Order" onclick="confirmorder('<?php echo $headtgl; ?>')" id="add-more"; class="btn btn-danger btn-sm" href="#!">CONFIRM </b></i></a>
		</span>
	</div>			
	<div class="card-body">
		<div class="card-body table-responsive p-0" style="height:550px;">
		<table class="table table-bordered table-sm table-striped table-head-fixed display2" id="" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th><center>NO</center></th>
                    <th><center>NIK</center></th>
                    <th><center>KARYAWAN</center></th>
                    <th><center>DEPARTEMEN</center></th>
                    <th><center>JAM 10</center></th>
                    <th><center>JAM 12</center></th>
                    <!-- <th><center>JAM 14</center></th> -->
                    <th><center>JAM 18</center></th>
                    <th><center>JAM 22</center></th>
                    <th><center>JAM 02</center></th>
                    <th><center>ORDER</center></th>
                    <th><center>ACTUAL</center></th>
					<th width="60"><center><a title="Reset" id="hapus_record" href="#!" class="btn-sm text-red"> <i class="fas fa-times-circle"></i></a>
					<input type="checkbox" onchange="checkAll(this)" name="chk[]" id="pilih_semua"><span class="baris_dipilih" id="jumlah_pilih"> 0</span></center></th>
				</tr>
			</thead>
			<tbody id="table-body">
			<?php $no =1; $tot10=0; $tot12=0; $tot14=0; $tot18=0; $tot22=0; $tot02=0; $totall=0;  $totact=0;
				while($record=mysqli_fetch_array($posts)){  $logtime=NULL;
					$nik = $record['nik'];
					$sqlorder = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order = '$headtgl' AND nik_karyawan='$nik'"); 
					$qkry = mysqli_query($konek,"SELECT * FROM karyawan WHERE nik='$nik'"); $dkry = mysqli_fetch_array($qkry);	
					$tgl1 = $headtgl." 06:00:00.000"; 	$tgl2 = $headtgl2." 06:00:00.000";	
					$resul1 = "SELECT [TimeLog] FROM [HITFPTA1].[dbo].[PersonalLog] WHERE [DateTime] BETWEEN '$tgl1' AND '$tgl2' AND FingerPrintID ='$dkry[kode_fg]' GROUP BY [TimeLog]";
					$fg_query = sqlsrv_query($connfinger, $resul1, array(), array( "Scrollable" => 'buffered' ));
					$fg = sqlsrv_query($connfinger, "SELECT CONVERT(varchar, [TimeLog]) AS loog  FROM [HITFPTA1].[dbo].[PersonalLog] WHERE [DateTime] BETWEEN '$tgl1' AND '$tgl2' AND FingerPrintID ='$dkry[kode_fg]'");
					$datafg=sqlsrv_num_rows($fg_query);
					while($datajam=sqlsrv_fetch_array($fg, SQLSRV_FETCH_ASSOC)){ 
						$logtime .= $datajam['loog'].",";
					}
					$dray = substr($logtime,0,-1);
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
					<!-- <td class="text-blue"><center><small><?php if($order['jam14']>0){echo $m14['judul_menu']; $or14++; $ord++;} ?></small></center></td> -->
					<td class="text-blue"><center><small><?php if($order['jam18']>0){echo $m18['judul_menu']; $or18++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam22']>0){echo $m22['judul_menu']; $or22++; $ord++;} ?></small></center></td>
					<td class="text-blue"><center><small><?php if($order['jam02']>0){echo $m02['judul_menu']; $or02++; $ord++;} ?></small></center></td>
					<td><center><small><?php if($ord>0){echo $ord;} ?></small></center></td>
					<td><center><small title="<?php echo $dray;?>"><?php if($aktual>0){echo $aktual;} ?></small></center></td>
					<td width="90"><center><small class="form-inline"><?php if($order['nik_karyawan']){?><i style="color:green;" class="fa fa-check-circle text-green"> Confirm </i>&nbsp; 
						<input type="checkbox" class="pgw_checkbox" data-pwg-id="<?php echo $order["id_order"]; ?>"><?php echo " (".timeIndonesia($order['uporder']).")";} ?></small></center></td>
				</tr>
			<?php  $tot10+=$or10; $tot12+=$or12; $tot14+=$or14; $tot18+=$or18; $tot22+=$or22; $tot02+=$or02; $totall+=$ord; $totact+=$aktual; } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4"><center>TOTAL ORDER</center></th>
					<th><center><?php if($tot10>0){echo $tot10;} ?></center></th>
					<th><center><?php if($tot12>0){echo $tot12;} ?></center></th>
					<!-- <th><center><?php if($tot14>0){echo $tot14;} ?></center></th> -->
					<th><center><?php if($tot18>0){echo $tot18;} ?></center></th>
					<th><center><?php if($tot22>0){echo $tot22;} ?></center></th>
					<th><center><?php if($tot02>0){echo $tot02;} ?></center></th>
					<th><center><?php if($totall>0){echo $totall;} ?></center></th>
					<th><center><?php if($totact>0){echo $totact;} ?></center></th>
					<th><center></center></th>
				</tr>
			</tfoot>
		</table>
		</div>
	</div>
</div>
<?php
	include('footer.php');
?>
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