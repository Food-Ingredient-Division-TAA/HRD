<?php
	include "koneksi.php";
	$sql = mysqli_query($konek, "SELECT * FROM week_table WHERE DATE(NOW()) BETWEEN tgl_awal AND tgl_akhir");
	$result = mysqli_fetch_array($sql);
	$week= $result['title_week'];
	$page ="video_player.php";
	$sec = "180";
?>
<head>
<meta charset="utf-8">
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MISS APPROVAL SPL</title>

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
<link rel="icon" href="assets/img/icbplogo.png">
<link rel="shortcut icon" href="assets/img/icbplogo.png" />
</head>
<div class="card">
	<div class="card-header">
		<span class="float-right">&nbsp;
		<a title="Cek Weekly Downtime" class="btn btn-info btn-md float-right" href="#"><i class="fas fa-block"> LIST BELUM APPROVE LEMBUR</i></a>
		</span>
		<span class="">&nbsp;
		<a title="" class="btn btn-success text-bold btn-sm" href="#"> HRD FID-TAA </span></i></a>
		</span>
		<span class="">&nbsp;
		<a title="" class="btn btn-danger btn-md" href="#"><i class="fas fa-clock"> <?php echo format_indo(date('Y-m-d')); ?> | <span class="jam"> </span></i></a>
		</span>
	</div>
    <div class="table-responsive p-0" style="height:570; font-size:12px; font-family:Calibri;">
      <table class="table table-bordered table-sm table-head-fixed text-nowrap display12" id="scroll" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th><center>NO</center></th>
            <th><center>NIK</center></th>
            <th><center>NAMA KARYAWAN</center></th>
            <th><center>DEPARTEMEN</center></th>
            <th><center>TGL MULAI LEMBUR</center></th>
            <th><center>JUMLAH</center></th>
          </tr>
        </thead>
        <tbody>
          <?php date_default_timezone_set('Asia/Jakarta');
          include_once('koneksihr.php'); 
          $year = date('Y');
          $sql = mysqli_query($konekhr, "SELECT * FROM lemburan WHERE stts_spl='1' GROUP BY nik_spl ORDER BY nama_spl, posisi_spl");
            $no=1; $nilai=0;
          while($data=mysqli_fetch_array($sql)){
            $sql2 = mysqli_query($konekhr, "SELECT * FROM lemburan WHERE stts_spl='1' AND nik_spl='$data[nik_spl]' ORDER BY tgl_spl DESC");
            $sql3 = mysqli_query($konekhr, "SELECT * FROM lemburan WHERE stts_spl='1' AND nik_spl='$data[nik_spl]' ORDER BY tgl_spl ASC");
			$jml = mysqli_num_rows($sql2); 
			while($data1 = mysqli_fetch_array($sql2)){ $tgla = $data1['tgl_spl'];}
			while($data2 = mysqli_fetch_array($sql3)){ $tglb = $data2['tgl_spl'];}
      if($jml>9){$strip="blink"; }else{$strip=NULL; }
      if($no%2==1){$text = "blue";}else{ $text="black";}
			?>
            <tr class="table-row <?php echo $strip; ?>" style="color:<?php echo $text; ?>; font-weight:bold; font-size:20px;" id="new_row_ajax">
            <td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $data['nik_spl']; ?></td>
            <td><?php echo $data['nama_spl']; ?></td>
            <td align="center"><?php echo $data['posisi_spl']; ?></td>
            <td align="center"><?php echo tglindonesia($tgla)." s/d ".tglindonesia($tglb); ?></td>
            <td align="center"><?php echo $jml; ?></td>
			</tr>
		<?php
            $no++;
          }
          $numb = $nilai;
          ?>
        </tbody>
      </table>
    </div>
</div>
<?php
	include('footer.php');
?>
<style>
.backgroundRed{background : pink;}
.blink {
	-webkit-transition :background 1.0s ease-in-out;
	-ms-transition :background 1.0s ease-in-out;
	transition :background 1.0s ease-in-out;
}
</style>
<script>
// function loadArray(){
// 	var tgl = "today";
// 	$.ajax({
// 		url: "spl_array.php",
// 		type: "POST",
// 		data:'headday='+tgl,
// 		success: function(data){
// 			$("#tablespl").load('spl_array.php #loadspl', function(){ $(this).text(); });
// 		}
// 	});
// } 
// loadArray();
// setInterval(function(){
//   loadArray()
// }, 1000);

var $div2blink = $(".blink");
var backgroundInterval = setInterval(function(){
	$div2blink.toggleClass("backgroundRed");
}, 1500)
var $el = $(".table-responsive");
function anim() {
  var st = $el.scrollTop();
  var sb = $el.prop("scrollHeight")-$el.innerHeight();
  $el.animate({scrollTop: st<sb/2 ? sb : 0}, 160000, anim);
}
function stop(){
  $el.stop();
}
anim();
$el.hover(stop, anim);


function getWeek(){
        var url = $("#week").val();
        if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
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