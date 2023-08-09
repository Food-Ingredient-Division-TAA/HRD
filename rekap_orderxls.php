<?php
	include('connect_finger.php');
	include "koneksi.php";
	include "koneksihr.php";
	include "conn_hygiene.php";
	include "db_controller.php";
	include('connect_finger.php');
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
	header("Content-type:application/vnd-ms-excel");
	header("Content-Disposition:attachment; filename=rekaporder ".$headtgl.".xls");
?>
<table border="1" id="" cellspacing="0" width="100%">
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
		$tgl1 = $headtgl." 06:00:00.000"; 	$tgl2 = $headtgl2." 06:00:00.000";	
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
</table>