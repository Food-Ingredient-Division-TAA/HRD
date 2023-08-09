<?php
ob_start();
session_start();
if(!isset($_SESSION['login'])){
	header('location:login.php');
}
include "koneksi.php";
include "conn_hygiene.php";
include "db_controller.php";
	$target = ""; $ttfood =0; $ttfood10 =0; $ttfood12 =0; $ttfood14 =0; $ttfood18 =0; $ttfood22 =0; $ttfood02 =0;
	$getweek = isset($_GET['getweek'])?$_GET['getweek']:$week;
	$unit = isset($_GET['unit'])?$_GET['unit']:NULL;
	if($unit!=NULL){$sql = "SELECT * FROM karyawan WHERE unit ='$unit' ORDER BY unit, nama_karyawan";}else{
	$sql = "SELECT * FROM karyawan WHERE unit !='Other' ORDER BY unit, nama_karyawan";}
	$db_handle = new DBController();
	$posts = mysqli_query($konek, $sql);
	header("Content-type:application/vnd-ms-excel");
	header("Content-Disposition:attachment; filename=order_menu ".$getweek.".xls");
?>
		<table class="table table-bordered table-sm table-striped table-head-fixed display2" border="1" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th colspan="24"><center>LIST ORDER MENU KANTIN WEEK <?php echo $getweek; ?></center></th>
				</tr>
				<tr>
                    <th rowspan="2"><center>NO</center></th>
                    <th rowspan="2"><center>MENU (Code)</center></th>
                    <th rowspan="2"><center>WAKTU</center></th>
					<?php $select = mysqli_query($konek, "SELECT * FROM week_table WHERE title_week='$getweek'");	$isi = mysqli_fetch_array($select);
						$tanggal1= date('Y-m-d', strtotime($isi['tgl_awal']));
						for($tgl=0;$tgl<$isi['jml_hari'];$tgl++){
							$tanggal2 = date('Y-m-d', strtotime('+'.$tgl.' days', strtotime($tanggal1)));
					?>
					<th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>" title="<?php echo format_indo($tanggal2); ?>" colspan="3"><center><?php echo format_indo($tanggal2); ?></center></th>
					<?php } ?>
				</tr>
				<tr>
					<?php $select = mysqli_query($konek, "SELECT * FROM week_table WHERE title_week='$getweek'");	$isi = mysqli_fetch_array($select);
						$tanggal1= date('Y-m-d', strtotime($isi['tgl_awal']));
						for($tgl=0;$tgl<$isi['jml_hari'];$tgl++){
							$tanggal2 = date('Y-m-d', strtotime('+'.$tgl.' days', strtotime($tanggal1)));
					?>
                    <th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small>TITLE</small></center></th>
                    <th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small>STOK</small></center></th>
                    <th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small>ORDER</small></center></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody id="table-body">
				<?php $no=1;
					$select = mysqli_query($konek, "SELECT * FROM week_table WHERE title_week='$getweek'");	$isi = mysqli_fetch_array($select);
					$tanggal1= date('Y-m-d', strtotime($isi['tgl_awal']));
					$allmenu = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tanggal2' ORDER BY jenis_menu DESC, kode_menu ASC");
					while($recmenu=mysqli_fetch_array($allmenu)){  $kode=NULL;
						if($recmenu['kode_menu']>='1'&&$recmenu['kode_menu']<='4'&&$recmenu['jenis_menu']=="UTAMA"){ $jam ="10.00 WIB";}elseif($recmenu['kode_menu']>='5'&&$recmenu['kode_menu']<='8'&&$recmenu['jenis_menu']=="UTAMA"){ $jam ="12.00 WIB";}
						elseif($recmenu['kode_menu']>='9'&&$recmenu['kode_menu']<='12'&&$recmenu['jenis_menu']=="UTAMA"){ $jam ="14.00 WIB";}elseif($recmenu['kode_menu']>='13'&&$recmenu['kode_menu']<='16'&&$recmenu['jenis_menu']=="UTAMA"){ $jam ="18.00 WIB";}
						elseif($recmenu['kode_menu']>='17'&&$recmenu['kode_menu']<='20'&&$recmenu['jenis_menu']=="UTAMA"){ $jam ="22.00 WIB";}elseif($recmenu['kode_menu']>='21'&&$recmenu['kode_menu']<='26'&&$recmenu['jenis_menu']=="UTAMA"){ $jam ="02.00 WIB";}else{$jam=NULL;}
				?>
				<tr>
                    <td width="50"><center><small><?php echo $no++; ?></small></center></td>
                    <td><center><b><small><?php echo $recmenu['jenis_menu']." (".$recmenu['kode_menu'].")";?></small></b></center></td>
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small><?php echo $jam; ?></small></center></td>
					<?php 
						for($tgl=0;$tgl<$isi['jml_hari'];$tgl++){ $allpo=0;
							$tanggal2 = date('Y-m-d', strtotime('+'.$tgl.' days', strtotime($tanggal1)));
							$menuquery = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tanggal2' AND jenis_menu='$recmenu[jenis_menu]' AND kode_menu='$recmenu[kode_menu]'"); 
							$menu = mysqli_fetch_array($menuquery);
							if($recmenu['jenis_menu']!="UTAMA"){
								$order10 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam10!='0'"); $po10 = mysqli_num_rows($order10);
								$order12 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam12!='0'"); $po12 = mysqli_num_rows($order12);
								$order14 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam14!='0'"); $po14 = mysqli_num_rows($order14);
								$order18 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam18!='0'"); $po18 = mysqli_num_rows($order18);
								$order22 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam22!='0'"); $po22 = mysqli_num_rows($order22);
								$order02 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam02!='0'"); $po02 = mysqli_num_rows($order02);
							}else{
								$order10 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam10='$recmenu[kode_menu]'"); $po10 = mysqli_num_rows($order10);
								$order12 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam12='$recmenu[kode_menu]'"); $po12 = mysqli_num_rows($order12);
								$order14 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam14='$recmenu[kode_menu]'"); $po14 = mysqli_num_rows($order14);
								$order18 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam18='$recmenu[kode_menu]'"); $po18 = mysqli_num_rows($order18);
								$order22 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam22='$recmenu[kode_menu]'"); $po22 = mysqli_num_rows($order22);
								$order02 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tanggal2' AND jam02='$recmenu[kode_menu]'"); $po02 = mysqli_num_rows($order02);
							}
							$allpo = $po10+$po12+$po14+$po18+$po22+$po02;
					?>
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small><?php echo $menu['judul_menu']; ?></small></center></td>
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small><?php echo $menu['quota_menu']; ?></small></center></td>
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?> color:red;" title="<?php echo $po10.",".$po12.",".$po14.",".$po18.",".$po22.",".$po02; ?>"><center><small><?php if($allpo>0){echo $allpo;} ?></small></center></td>
					<?php $kode.=$menu['id_menu'].","; } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>