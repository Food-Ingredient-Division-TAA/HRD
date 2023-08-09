<?php
	$page = "ORDER MAKAN KARYAWAN";
	$makan = "";
	$menu = "";
	include('header.php');
	$target = ""; $ttfood =0; $ttfood10 =0; $ttfood12 =0; $ttfood14 =0; $ttfood18 =0; $ttfood22 =0; $ttfood02 =0;
	$getweek = isset($_GET['getweek'])?$_GET['getweek']:$week;
	$unit = isset($_GET['unit'])?$_GET['unit']:NULL;
	if($unit!=NULL){$sql = "SELECT * FROM karyawan WHERE unit ='$unit' ORDER BY unit, nama_karyawan";}else{
	$sql = "SELECT * FROM karyawan WHERE unit !='Other' ORDER BY unit, nama_karyawan";}
	$db_handle = new DBController();
	$posts = mysqli_query($konek, $sql);
?>
<?php
if(isset($_POST['setmenu'])){
	$pweek = isset($_POST['week'])?$_POST['week']:NULL;
	$jenis = isset($_POST['jenis'])?$_POST['jenis']:NULL;
	$kode = isset($_POST['kode'])?$_POST['kode']:NULL;
	$nama = isset($_POST['nama'])?$_POST['nama']:NULL;
	$quota = isset($_POST['quota'])?$_POST['quota']:NULL;
	$select = mysqli_query($konek, "SELECT * FROM week_table WHERE title_week='$pweek'");	$isi = mysqli_fetch_array($select);
	$tanggal1= date('Y-m-d', strtotime($isi['tgl_awal']));
	for($tgl=0;$tgl<$isi['jml_hari'];$tgl++){ $tanggal2 = date('Y-m-d', strtotime('+'.$tgl.' days', strtotime($tanggal1)));
		$sql = mysqli_query($konek,"INSERT INTO `menu_makan`(`id_menu`, `tgl_menu`, `kode_menu`, `jenis_menu`, `judul_menu`, `quota_menu`) 
		VALUES ('','$tanggal2','$kode','$jenis','$nama','$quota')");
	}
	if($sql){
?>
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo "Menu berhasil di daftarkan !"; ?>
	</div>
<?php
	header("Refresh:1; url=menu.php?getweek=$pweek");}else{
	header("Refresh:1; url=menu.php?getweek=$pweek");
	} 
}
?>
<div class="card">
	<div class="card-header">
			<span>&nbsp;
				<a title="Food Order" class="btn btn-danger btn-sm" target="blank" href="#!"><i class="fas fa-hamburger"> Kode Utama : Jam10 (1-4) | Jam12 (5-8) | Jam14 (9-12) | Jam18 (13-16) | Jam22 (17-20) | Jam02 (21-26)</i></a>
			</span>&nbsp;
			<span class="float-right">&nbsp;
			<a title="Save & Reload" class="btn btn-primary btn-sm float-right" href=""><i class="fas fa-sync"></i></a>
			</span>
			<!-- <span class="float-right">&nbsp;
			<a title="Print Jadwal Manpower Pdf" class="btn btn-info btn-sm float-right" target="blank" href="#!"><i class="fas fa-file-pdf"></i></a>
			</span>&nbsp; -->
			<span class="float-right">&nbsp;
			<a title="Print List Order Menu" class="btn btn-warning btn-sm float-right" target="blank" href="menu_xls.php?getweek=<?php echo $getweek; ?>"><i class="fas fa-file-excel"></i></a>
			</span>&nbsp;
			<span class="float-right">&nbsp;
			<a title="Reset" href="#!" class="btn btn-success btn-sm float-right" onclick="inputmenu('<?php echo $getweek; ?>','WAJIB')"><small><i class="fas fa-plus-circle"> WAJIB</i></small></a>
			</span>&nbsp;
			<span class="float-right">&nbsp;
			<a title="Reset" href="#!" class="btn btn-success btn-sm float-right" onclick="inputmenu('<?php echo $getweek; ?>','UTAMA')"><small><i class="fas fa-plus-circle"> UTAMA</i></small></a>
			</span>&nbsp;
			<span class="float-right">&nbsp;
			<a title="Reset" href="#!" class="btn btn-success btn-sm float-right" onclick="inputmenu('<?php echo $getweek; ?>','TAMBAHAN')"><small><i class="fas fa-plus-circle"> TAMBAHAN</i></small></a>
			</span>&nbsp;
			<h3 class="card-title">
				<select onChange="getWeek()" class="form-control-sm" id="week" name="week">
					<option value="">--Get Week--</option>
					<?php $year = date('Y');
						$get = isset($_GET['getweek'])?$_GET['getweek']:NULL;
						$select = mysqli_query($konek,"SELECT * FROM week_table WHERE YEAR(tgl_awal)='$year' ORDER BY tgl_awal ASC");
						while($n=mysqli_fetch_array($select)){ ?>
							<option value="?getweek=<?php echo $n['title_week']; ?>" <?php if($get==$n['title_week']){echo "selected";} ?>>Week <?php echo substr($n['title_week'],5); ?></option>
					<?php
						}
					?>
				<select>
			</h3>
	</div>			
	<div class="card-body">
		<div class="card-body table-responsive p-0" style="height:550px;">
		<table class="table table-bordered table-sm table-striped table-head-fixed display2" id="" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th rowspan="2"><center>NO</center></th>
                    <th rowspan="2"><center>MENU (Code)</center></th>
					<?php $select = mysqli_query($konek, "SELECT * FROM week_table WHERE title_week='$getweek'");	$isi = mysqli_fetch_array($select);
						$tanggal1= date('Y-m-d', strtotime($isi['tgl_awal']));
						for($tgl=0;$tgl<$isi['jml_hari'];$tgl++){
							$tanggal2 = date('Y-m-d', strtotime('+'.$tgl.' days', strtotime($tanggal1)));
					?>
					<th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>" title="<?php echo format_indo($tanggal2); ?>" colspan="3"><center><?php echo strtoupper(substr(format_indo($tanggal2),0,6)); ?></center></th>
					<?php } ?>
					<th rowspan="2" width="60"><center><a title="Reset" id="hapus_record" href="#!" class="btn-sm text-red"> <i class="fas fa-times-circle"></i></a>
					<input type="checkbox" onchange="checkAll(this)" name="chk[]" id="pilih_semua"><span class="baris_dipilih" id="jumlah_pilih"> 0</span></center></th>
				</tr>
				<tr>
					<?php $select = mysqli_query($konek, "SELECT * FROM week_table WHERE title_week='$getweek'");	$isi = mysqli_fetch_array($select);
						$tanggal1= date('Y-m-d', strtotime($isi['tgl_awal']));
						for($tgl=0;$tgl<$isi['jml_hari'];$tgl++){
							$tanggal2 = date('Y-m-d', strtotime('+'.$tgl.' days', strtotime($tanggal1)));
					?>
                    <th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small>TITLE</small></center></th>
                    <th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small>STOK</small></center></th>
                    <th style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>"><center><small>PO</small></center></th>
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
                    <td><center><b><small><?php echo "(".$recmenu['kode_menu'].")".$recmenu['jenis_menu']."-".$jam."";?></small></b></center></td>
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
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>" contenteditable="true" onBlur="saveToDatabase(this,'judul_menu','<?php echo $menu["id_menu"]; ?>')" onClick="editRow(this);"><center><small><?php echo $menu['judul_menu']; ?></small></center></td>
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>" contenteditable="true" onBlur="saveToDatabase(this,'quota_menu','<?php echo $menu["id_menu"]; ?>')" onClick="editRow(this);"><center><small><?php echo $menu['quota_menu']; ?></small></center></td>
					<td style="<?php if($tgl%2==0){ echo "background:rgba(100,200,0,0.1);"; } ?>" title="<?php echo $po10.",".$po12.",".$po14.",".$po18.",".$po22.",".$po02; ?>"><center><small class="text-red"><?php if($allpo>0){echo $allpo;} ?></small></center></td>
					<?php $kode.=$menu['id_menu'].","; } ?>
					<td align="center"><input type="checkbox" class="pgw_checkbox" data-pwg-id="<?php echo $kode; ?>"/></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
</div>
<?php
	include('footer.php');
?>
<script>
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
function getWeek(){
        var url = $("#week").val();
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
function inputmenu(week,jenis){
var tweek = week;
var type = jenis;
const link = 'popup_menuwajib.php';
	$.ajax({
		url: link,
		method: 'post',
		data: {tweek:tweek,type:type},
		success:function(data){
			$('#modal-default').modal("show");
			$('#tampil_modal').html(data);
			document.getElementById("judul").innerHTML='Add Menu '+type+' '+ tweek;
		}
	});
}
function editRow(editableObj) {
  $(editableObj).css("background","#FFF");
//   $(editableObj).empty();
}

function saveToDatabase(editableObj,column,id) {
  $(editableObj).css("background","#FFF url(assets/img/loaderIcon.gif) no-repeat right");
  $.ajax({
    url: "menu_edit.php",
    type: "POST",
    data:'column='+column+'&editval='+$(editableObj).text()+'&id='+id,
    success: function(data){
      $(editableObj).css("background","#FDFDFD");
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
    url: "menu_del.php",
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