<?php
	$page = "SPL NOTIF";
	$spl = "";
	include('header.php');
	if(isset($_GET['print'])){
		$tabel = "example1";
	}else{ $tabel = "";}	
	if(isset($_GET['day'])){$headtgl = $_GET['day'];}else{$headtgl=date('Y-m-d'); }
	if(isset($_GET['day2'])){$headtgl2 = $_GET['day2'];}else{$headtgl2=date('Y-m-d'); }
	$getweek = isset($_GET['getweek'])?$_GET['getweek']:NULL;
	if($getweek){ $minggu = $getweek;
		echo "<input type='hidden' value='".$getweek."' id='mggu' name='mggu'/>";
	}else{ echo "<input type='hidden' value='".$week."' id='mggu' name='mggu'/>"; $minggu = $week;}
?>
<?php if(isset($_GET['berhasil'])){ ?>
<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $_GET['berhasil']." data berhasil di record !"; ?>
</div>
<?php }else{NULL;} ?>
<input type="hidden" id="tgljam" value="<?php echo $headtgl2." ".date('H:i:s'); ?>"/>
<div class="card">
	<div class="card-header">
			<span>&nbsp;
			<input type="date" class="form-control-sm" value="<?php if(isset($_POST['day'])){ echo $_POST['day'];}else{echo $headtgl;} ?>" id="tgl1" required/> 
			<input onchange="rangeday()" class="form-control-sm" type="date" value="<?php if(isset($_POST['day2'])){ echo $_POST['day2'];}else{echo $headtgl2;} ?>" id="tgl2" required/> 
			</span>
			<span class="float-right">&nbsp;
			<a title="Cek Pengumuman" class="btn btn-danger btn-sm float-right" target="blank" href="lembur.php"><i class="fa fa-tv"></i></a>
			</span>
			<span class="float-right">&nbsp;
			<a title="Upload List" onclick="uploadspl()" class="btn btn-primary btn-sm float-right" href="#!"><i class="fas fa-upload"> Upload</i></a>
			</span>
			<span class="float-right">&nbsp;
			<a title="Download Template" class="btn btn-warning btn-sm float-right" href="tmp_spl.xls"><i class="fa fa-file-excel"> Template</i></a>
			</span>
	</div>				
	<div class="card-body table-responsive p-0" style="height:500px;">
		<table class="table table-bordered table-sm table-striped table-head-fixed display3" id="<?php echo $tabel; ?>" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th><center>NO</center></th>
				<th><center>NO. DOK</center></th>
				<th><center>NIK</center></th>
				<th><center>NAMA KARYAWAN</center></th>
				<th><center>DEPARTEMEN</center></th>
				<th><center>TGL LEMBUR</center></th>
				<th><center>JAM MULAI</center></th>
				<th><center>JAM SELESAI</center></th>
				<th><center>LINTAS HARI</center></th>
				<th><center>STATUS</center></th>
				<th><center><a title="Delete" id="hapus_record" href="#!" class="btn-sm text-red"> <i class="fas fa-trash-alt"></i></a>
				<input type="checkbox" onchange="checkAll(this)" name="chk[]" id="pilih_semua"><span class="baris_dipilih" id="jumlah_pilih">0</span></center></th>
			</tr>
		</thead>
		<tbody id="table-body">
			<?php $no=1;
			if(isset($_GET['day2'])){
				$query = mysqli_query($konekhr,"SELECT * FROM `lemburan` WHERE tgl_spl BETWEEN '$headtgl' AND '$headtgl2'");
			}else{
				$query = mysqli_query($konekhr,"SELECT * FROM `lemburan` WHERE stts_spl = '1'");
			}
				while($data=mysqli_fetch_array($query)){
			?>
			<tr id="<?php echo $data['id_lembur']; ?>">
				<td align="center"><?php echo $no++; ?></td>
				<td align="center"><?php echo $data['no_spl'];?></td>
				<td align="center"><?php echo $data['nik_spl']; ?></td>
				<td><?php echo $data['nama_spl']; ?></td>
				<td><?php echo $data['posisi_spl']; ?></td>
				<td align="center"><?php echo format_indo($data['tgl_spl']); ?></td>
				<td align="center"><?php echo $data['jam_start']; ?></td>
				<td align="center"><?php echo $data['jam_end']; ?></td>
				<td align="center"><?php echo $data['lintas_hari']; ?></td>
				<td align="center">
				<a href="#!" onclick="roleStatus<?php echo $data['stts_spl'];?>('<?php echo $data['id_lembur']; ?>', '<?php echo $no;?>buttonstts<?php echo $data['stts_spl'];?>')"  id="<?php echo $no;?>buttonstts<?php echo $data['stts_spl'];?>">
					<!-- <?php if($data['stts_spl']=="0"){ ?><i title="COMPLETE" class="fas fa-check-circle text-green"></i> <?php }else{ ?><i title="Belum Approve" class="fas fa-times-circle text-red"></i> <?php } ?> -->
				</a>
				</td>
				<td align="center" width="60">
				<!-- <a title="Update" onclick="editSPL('<?php echo $data['id_lembur'];?>')" href="#!" class="btn-sm text-orange"><i class="fas fa-edit"></i></a> -->
				<input title="<?php echo $data["id_lembur"]; ?>" type="checkbox" class="pgw_checkbox" data-pwg-id="<?php echo $data["id_lembur"]; ?>"></td>
			</tr>
			<?php
				}
			?>
			<input type="hidden" value="<?php echo $no; ?>" id="no"/>
		</tbody>
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
function rangeday(){
	var tgl1 = $("#tgl1").val();
	var tgl2 = $("#tgl2").val();
        var url = "?day="+tgl1+"&day2="+tgl2;
        if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
}
$(document).ready(function() {
    $('.display3').DataTable( {
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
 $(document).ready(function () {
      $('#clock').select2({
		data: data
      });
  });
function getWeek(){
        var url = $("#week").val();
        if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
}
</script>
<script>
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
    url: "spl_del.php",
    cache:false,
    data: 'pwg_id='+selected_values,
    success: function(response) {
     // menghilangkan baris pegawai yang dihapus
     var pgw_ids = response.split(",");
     for (var i=0; i<pgw_ids.length; i++ ) {
	  $("#"+pgw_ids[i]).remove();
	  location.reload();
     }
    }
   });
  }
 }
});
function deleteRecord(id) {
	if(confirm("Are you sure you want to delete this row?")) {
		$.ajax({
			url: "spl_delete.php",
			type: "POST",
			data:'id='+id,
			success: function(data){
			  $("#table-row-"+id).remove();
            //   location.reload();
			}
		});
	}
}
var nomor = $("#no").val();
for(i=1; i<=nomor; i++){
$("#"+i+"buttonstts0").addClass('fas fa-check-circle text-green');
$("#"+i+"buttonstts1").addClass('fas fa-times-circle text-red');
}
function roleStatus0(kode, id) {
  $.ajax({
    url: "spl_edit.php",
    type: "POST",
    data:'kode=1&id='+kode,
    success: function(data){
    $("#"+id).removeClass('fas fa-check-circle text-green');
    $("#"+id).addClass('fas fa-times-circle text-red');
    }
  });
}
function roleStatus1(kode, id) {
  $.ajax({
    url: "spl_edit.php",
    type: "POST",
    data:'kode=0&id='+kode,
    success: function(data){
    $("#"+id).removeClass('fas fa-times-circle text-red');
    $("#"+id).addClass('fas fa-check-circle text-green');
    }
  });
}
</script>