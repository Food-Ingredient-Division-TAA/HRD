<?php
	$page = "REKAP ORDER KANTIN";
	$makan = "";
	$rekap = "";
	include('connect_finger.php');
	include('header.php');
	$target = ""; $ttfood =0; $ttfood10 =0; $ttfood12 =0; $ttfood14 =0; $ttfood18 =0; $ttfood22 =0; $ttfood02 =0;
	if(isset($_GET['day'])){ $headtgl = $_GET['day'];}else{	$headtgl=date('Y-m-d'); }
	$headtgl2 = date('Y-m-d', strtotime('+1 days', strtotime($headtgl)));
	$qweek = mysqli_query($konek,"SELECT * FROM `week_table` WHERE `tgl_awal` <= '$headtgl' AND `tgl_akhir` >= '$headtgl'"); $title=mysqli_fetch_array($qweek);
	$unit = isset($_GET['unit'])?$_GET['unit']:NULL;
	echo "<input type='hidden' value='".$headtgl."' id='harikerja' name='harikerja'/>";
	if($unit!=NULL){$sql = "SELECT * FROM karyawan WHERE unit ='$unit' ORDER BY unit, nama_karyawan";}else{
	$sql = "SELECT * FROM karyawan WHERE unit !='Other' GROUP BY unit ";}
	$db_handle = new DBController();
	$posts = mysqli_query($konek, $sql);
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
			<a title="Print Jadwal Manpower Excel" class="btn btn-warning btn-sm float-right" target="blank" href="rekap_orderxls.php?day=<?php echo $headtgl; ?>"><i class="fas fa-file-excel"></i></a>
			</span>&nbsp;
		<h3 class="card-title">
		<?php date_default_timezone_set('Asia/Jakarta');
		 $back = date('Y-m-d', strtotime('-1 days', strtotime($headtgl))); $next = date('Y-m-d', strtotime('+1 days', strtotime($headtgl)));?>
			<!-- <a title="<?php echo format_indo($back); ?>" class="btn btn-default btn-sm" href="?day=<?php echo $back; ?>"><li class="fas fa-angle-double-left "></li> Prev </a> 
			<a class="btn btn-default btn-sm" href="#!"><strong> <?php echo format_indo($headtgl); ?> </strong></a>
			<a class="btn btn-default btn-sm" title="<?php echo format_indo($next);?>" href="?day=<?php echo $next; ?>">  Next <li class="fas fa-angle-double-right "></li></a> -->
			<input onchange="changeday();" class="form-control-sm" id="boxtgl" type="date" value="<?php echo $headtgl; ?>"/> 
	</div>			
	<div class="card-body">
		<div class="card-body table-responsive p-0" style="height:550px;">
		<table class="table table-bordered table-sm table-striped table-head-fixed display2" id="" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th><center>NO</center></th>
                    <th><center>DEPARTEMEN</center></th>
                    <th><center>JAM 10</center></th>
                    <th><center>JAM 12</center></th>
                    <!-- <th><center>JAM 14</center></th> -->
                    <th><center>JAM 18</center></th>
                    <th><center>JAM 22</center></th>
                    <th><center>JAM 02</center></th>
                    <th><center>ORDER</center></th>
                    <th><center>ACTUAL</center></th>
					<!-- <th width="60"><center><a title="Reset" id="hapus_record" href="#!" class="btn-sm text-red"> <i class="fas fa-times-circle"></i></a>
					<input type="checkbox" onchange="checkAll(this)" name="chk[]" id="pilih_semua"><span class="baris_dipilih" id="jumlah_pilih"> 0</span></center></th> -->
				</tr>
			</thead>
			<tbody id="table-body">
			<?php $no =1; $tot10=0; $tot12=0; $tot14=0; $tot18=0; $tot22=0; $tot02=0; $totall=0;  $totact=0;
				while($record=mysqli_fetch_array($posts)){  
				$unit = isset($record['unit'])?$record['unit']:NULL;
				$order10 = mysqli_query($konek,"SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik=order_makan.nik_karyawan WHERE tgl_order = '$headtgl' AND unit='$unit' AND jam10>0"); 
				$rec10=mysqli_num_rows($order10);
				$order12 = mysqli_query($konek,"SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik=order_makan.nik_karyawan WHERE tgl_order = '$headtgl' AND unit='$unit' AND jam12>0"); 
				$rec12=mysqli_num_rows($order12);
				$order14 = mysqli_query($konek,"SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik=order_makan.nik_karyawan WHERE tgl_order = '$headtgl' AND unit='$unit' AND jam14>0"); 
				$rec14=mysqli_num_rows($order14);
				$order18 = mysqli_query($konek,"SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik=order_makan.nik_karyawan WHERE tgl_order = '$headtgl' AND unit='$unit' AND jam18>0"); 
				$rec18=mysqli_num_rows($order18);
				$order22 = mysqli_query($konek,"SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik=order_makan.nik_karyawan WHERE tgl_order = '$headtgl' AND unit='$unit' AND jam22>0"); 
				$rec22=mysqli_num_rows($order22);
				$order02 = mysqli_query($konek,"SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik=order_makan.nik_karyawan WHERE tgl_order = '$headtgl' AND unit='$unit' AND jam02>0"); 
				$rec02=mysqli_num_rows($order02);
				$allrec = $rec02+$rec22+$rec18+$rec14+$rec12+$rec10;	
				$kry = mysqli_query($konek, "SELECT * FROM karyawan WHERE unit='$unit'");  $dept=0;
				while($dkry=mysqli_fetch_array($kry)){
				$tgl1 = $headtgl." 06:00:00"; 	$tgl2 = $headtgl2." 06:00:00";	
				$resul1 = "SELECT [TimeLog] FROM [HITFPTA1].[dbo].[PersonalLog] WHERE [DateTime] BETWEEN '$tgl1' AND '$tgl2' AND FingerPrintID ='$dkry[kode_fg]' GROUP BY [TimeLog]";
				$fg_query = sqlsrv_query($connfinger, $resul1, array(), array( "Scrollable" => 'static' ));
				$datafg=sqlsrv_num_rows($fg_query);
				$aktual = number_format($datafg);
				$dept+=$aktual;
				}
			?>
				<tr class="table-row" id="table-row-<?php echo $record['nik']; ?>">
					<td align="center" width="10"><?php echo $no++; ?></td>
					<td width="10"><center><?php echo $unit; ?></center></td>
					<td width="10"><center><?php if($rec10>0){echo $rec10;} ?></center></td>
					<td width="10"><center><?php if($rec12>0){echo $rec12;} ?></center></td>
					<!-- <td width="10"><center><?php if($rec14>0){echo $rec14;} ?></center></td> -->
					<td width="10"><center><?php if($rec18>0){echo $rec18;} ?></center></td>
					<td width="10"><center><?php if($rec22>0){echo $rec22;} ?></center></td>
					<td width="10"><center><?php if($rec02>0){echo $rec02;} ?></center></td>
					<td width="10"><center><?php if($allrec>0){echo $allrec;} ?></center></td>
					<td width="10"><center><?php if($dept>0){echo $dept;} ?></center></td>
				</tr>
			<?php  $tot10+=$rec10; $tot12+=$rec12; $tot14+=$rec14; $tot18+=$rec18; $tot22+=$rec22; $tot02+=$rec02; $totall+=$allrec; $totact+=$dept; } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2"><center>TOTAL ORDER</center></th>
					<th><center><?php if($tot10>0){echo $tot10;} ?></center></th>
					<th><center><?php if($tot12>0){echo $tot12;} ?></center></th>
					<!-- <th><center><?php if($tot14>0){echo $tot14;} ?></center></th> -->
					<th><center><?php if($tot18>0){echo $tot18;} ?></center></th>
					<th><center><?php if($tot22>0){echo $tot22;} ?></center></th>
					<th><center><?php if($tot02>0){echo $tot02;} ?></center></th>
					<th><center><?php if($totall>0){echo $totall;} ?></center></th>
					<th><center><?php if($totact>0){echo $totact;} ?></center></th>
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