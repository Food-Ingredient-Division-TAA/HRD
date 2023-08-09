<?php
	include "connhygiene.php";
	$sql = mysqli_query($konek, "SELECT * FROM week_table WHERE DATE(NOW()) BETWEEN tgl_awal AND tgl_akhir");
	$result = mysqli_fetch_array($sql);
	$week= $result['title_week'];
	$page ="lembur.php";
	$sec = "120";
?>
<head>
<meta charset="utf-8">
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HYGIENE AREA STATUS</title>

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
		<a title="Cek Weekly Downtime" class="btn btn-primary btn-md float-right" href="#"><i class="fas fa-block"> STATUS AREA</i></a>
		</span>
		<span class="">&nbsp;
		<a title="" class="btn btn-danger btn-md" href="#"><i class="fas fa-clock"> <?php echo format_indo(date('Y-m-d')); ?> | <span class="jam"> </span></i></a>
		</span>
		<span class="">&nbsp;
		<a title="" class="btn btn-light text-pink text-bold btn-sm" href="#"> HYGIENE - FID TAA </span></i></a>
		</span>
	</div>
</div>

<div class="table-responsive p-0" style="height:570; font-size:14px;">
  <table class="table table-bordered table-sm table-head-fixed text-nowrap display12" id="scroll"  cellspacing="0" width="100%">
    <thead>
    </thead>
    <tbody>
      <tr>
        <td>
            <span>&nbsp;
            <a title="" class="btn btn-primary btn-sm" href="#!"><i class="fas fa-cube"> Area Produksi Bumbu</i></a>
            </span>
            <span class="float-right">
              <a class="btn btn-default btn-sm" type="checkbox"><small>Unrated</small></a>
              <a class="btn btn-default btn-sm" style="background:skyblue;" type="checkbox"><small>Rate A (>=2 MN, >=1 MJ)</small></a>
              <a class="btn btn-default btn-sm" style="background:lime;" type="checkbox"><small>Rate A (>=3 BR)</small></a>
              <a class="btn btn-default btn-sm" style="background:yellow;" type="checkbox"><small>Rate B (>=7 MN, 6-10 MJ, 1-2 SR)</small></a>
              <a class="btn btn-default btn-sm" style="background:salmon;" type="checkbox"><small>Rate C (>=7 MJ, 3-4 SR)</small></a>
              <a class="btn btn-default btn-sm" style="background:rgba(0,0,0,0.6); color:white;" type="checkbox"><small>Rate D (3-4 SR, >=1 KT)</small></a>
            </span>
        </td>
      </tr>
      <tr>
        <td style="background:linear-gradient(white 50%,lightblue,skyblue);">
          <?php $sqlbmb = mysqli_query($konek,"SELECT * FROM area WHERE dept_area ='BUMBU'"); $num = 1;
          while($dtbmb=mysqli_fetch_array($sqlbmb)){ $num++;
            $qstsmn=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtbmb[kode_area]' AND urgensi LIKE '%MN%' AND find_status!='C'");
            $qtymn = mysqli_num_rows($qstsmn); 
            $qstsmj=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtbmb[kode_area]' AND urgensi LIKE '%MJ%' AND find_status!='C'");
            $qtymj = mysqli_num_rows($qstsmj); 
            $qstsr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtbmb[kode_area]' AND urgensi LIKE '%SR%' AND find_status!='C'");
            $qtysr = mysqli_num_rows($qstsr); 
            $qstkt=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtbmb[kode_area]' AND urgensi LIKE '%KT%' AND find_status!='C'");
            $qtykt = mysqli_num_rows($qstkt); 
            $qstbr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtbmb[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C'");
            $qtybr = mysqli_num_rows($qstbr);
            $qhyg=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtbmb[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C' AND find_hygiene!=''");
            $qtyhyg = mysqli_num_rows($qhyg);
            if($qtykt>=1||$qtysr>=5){$rating="D"; $bg="background:rgba(0,0,0,0.6); color:white;";
            }elseif($qtysr>=3||$qtymj>=11){$rating="C"; $bg="background:salmon;";}elseif($qtysr>=1||$qtymj>=6||$qtymn>=7){$rating="B"; $bg="background:yellow;";}
            elseif($qtybr>=3){$rating="A"; $bg="background:lime;";}elseif($qtymn>=2||$qtymj>=1){$rating="A"; $bg="background:skyblue;";}else{$rating="A"; $bg="";}
          ?>
          <span class="col-sm-2 btn-sm btn btn-default" style="margin-bottom:5px; <?php echo $bg; ?>"><b class="btn btn-primary btn-sm float-left" title="" href="#!"> <?php echo $dtbmb['kode_area'];?></b> <b><?php echo substr($dtbmb['nama_area'],0,30);?></b>
          <hr style="margin-bottom:0px;"/>
          <span class="btn btn-sm "><small><b>MINOR : <?php echo $qtymn; ?></b></small></span>
          <span class="btn btn-sm "><small><b>MAYOR : <?php echo $qtymj; ?></b></small></span><br/>
          <span class="btn btn-sm "><small><b>SERIUS : <?php echo $qtysr; ?></b></small></span>
          <span class="btn btn-sm "><small><b>KRITIS : <?php echo $qtykt; ?></b></small></span>
          <span class="btn btn-sm "><small><b>BR : <?php echo $qtybr; ?></b></small></span>
          <hr style="margin:0px;"/>
          <a title="Live Cam" style="background:maroon; color:white;" target="blank" href="<?php if($dtbmb['cam_area']!=""){echo $dtbmb['cam_area'];}else{ echo "#!";} ?>" class="float-left btn btn-sm btn-default"><small><i class="fa fa-video"></i></small></a>
          <a title="History" href="#!" onclick="history('<?php echo $dtbmb['kode_area'];?>')" style="background:maroon; color:white;" class="float-left btn btn-sm btn-default"><small><i class="fa fa-list"></i></small></a>
          <span class="btn btn-sm "><b>RATING :  <?php echo $rating; ?></b></span>
          </span>
          <?php if($num==6||$num==11||$num==16){echo "<br/>";} } ?>
        </td>
      </tr>
      <tr>
        <td>
          <span>&nbsp;
          <a class="btn btn-warning btn-sm" href="#!"><i class="fas fa-cube"> Area Produksi Minyak</i></a>
          </span>
          <span class="float-right">
            <a class="btn btn-default btn-sm" type="checkbox"><small>Unrated</small></a>
            <a class="btn btn-default btn-sm" style="background:skyblue;" type="checkbox"><small>Rate A (>=2 MN, >=1 MJ)</small></a>
            <a class="btn btn-default btn-sm" style="background:lime;" type="checkbox"><small>Rate A (>=3 BR)</small></a>
            <a class="btn btn-default btn-sm" style="background:yellow;" type="checkbox"><small>Rate B (>=7 MN, 6-10 MJ, 1-2 SR)</small></a>
            <a class="btn btn-default btn-sm" style="background:salmon;" type="checkbox"><small>Rate C (>=7 MJ, 3-4 SR)</small></a>
            <a class="btn btn-default btn-sm" style="background:rgba(0,0,0,0.6); color:white;" type="checkbox"><small>Rate D (3-4 SR, >=1 KT)</small></a>
          </span>
        </td>
      </tr>
      <tr>
        <td style="background:linear-gradient(white 60%,lightyellow,yellow);">	
          <?php $sqlmyk = mysqli_query($konek,"SELECT * FROM area WHERE dept_area ='MINYAK'");  $num2 = 1;
          while($dtmyk=mysqli_fetch_array($sqlmyk)){ $num2++;
            $qstsmn=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtmyk[kode_area]' AND urgensi LIKE '%MN%' AND find_status!='C'");
            $qtymn = mysqli_num_rows($qstsmn); 
            $qstsmj=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtmyk[kode_area]' AND urgensi LIKE '%MJ%' AND find_status!='C'");
            $qtymj = mysqli_num_rows($qstsmj); 
            $qstsr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtmyk[kode_area]' AND urgensi LIKE '%SR%' AND find_status!='C'");
            $qtysr = mysqli_num_rows($qstsr); 
            $qstkt=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtmyk[kode_area]' AND urgensi LIKE '%KT%' AND find_status!='C'");
            $qtykt = mysqli_num_rows($qstkt); 
            $qstbr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtmyk[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C'");
            $qtybr = mysqli_num_rows($qstbr);
            $qhyg=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtmyk[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C' AND find_hygiene!=''");
            $qtyhyg = mysqli_num_rows($qhyg);
            if($qtykt>=1||$qtysr>=5){$rating="D"; $bg="background:rgba(0,0,0,0.6); color:white;";
            }elseif($qtysr>=3||$qtymj>=11){$rating="C"; $bg="background:salmon;";}elseif($qtysr>=1||$qtymj>=6||$qtymn>=7){$rating="B"; $bg="background:yellow;";}
            elseif($qtybr>=3){$rating="A"; $bg="background:lime;";}elseif($qtymn>=2||$qtymj>=1){$rating="A"; $bg="background:skyblue;";}else{$rating="A"; $bg="";}
          ?>
          <span class="col-sm-2 btn-sm btn btn-default" style="margin-bottom:5px; <?php echo $bg; ?>"><b class="btn btn-warning btn-sm float-left" title="" href="#!"> <?php echo $dtmyk['kode_area'];?></b> <b><?php echo substr($dtmyk['nama_area'],0,30);?></b>
          <hr style="margin-bottom:0px;"/>
          <span class="btn btn-sm "><small><b>MINOR : <?php echo $qtymn; ?></b></small></span>
          <span class="btn btn-sm "><small><b>MAYOR : <?php echo $qtymj; ?></b></small></span><br/>
          <span class="btn btn-sm "><small><b>SERIUS : <?php echo $qtysr; ?></b></small></span>
          <span class="btn btn-sm "><small><b>KRITIS : <?php echo $qtykt; ?></b></small></span>
          <span class="btn btn-sm "><small><b>BR : <?php echo $qtybr; ?></b></small></span>
          <hr style="margin:0px;"/>
          <a title="Live Cam" style="background:maroon; color:white;" target="blank" href="<?php if($dtmyk['cam_area']!=""){echo $dtmyk['cam_area'];}else{ echo "#!";} ?>" class="float-left btn btn-sm btn-default"><small><i class="fa fa-video"></i></small></a>
          <a title="History" href="#!" onclick="history('<?php echo $dtmyk['kode_area'];?>')" style="background:maroon; color:white;" class="float-left btn btn-sm btn-default"><small><i class="fa fa-list"></i></small></a>
          <span class="btn btn-sm "><b>RATING :  <?php echo $rating; ?></b></span>
          </span>
          <?php if($num2==6||$num2==11||$num2==16){echo "<br/>";} } ?>
        </td>
      </tr>
      <tr>
        <td>
          <span>&nbsp;
          <a title="" class="btn btn-success btn-sm" href="#!"><i class="fas fa-home"> Area Warehouse</i></a>
          </span>
          <span class="float-right">
            <a class="btn btn-default btn-sm" type="checkbox"><small>Unrated</small></a>
            <a class="btn btn-default btn-sm" style="background:skyblue;" type="checkbox"><small>Rate A (>=2 MN, >=1 MJ)</small></a>
            <a class="btn btn-default btn-sm" style="background:lime;" type="checkbox"><small>Rate A (>=3 BR)</small></a>
            <a class="btn btn-default btn-sm" style="background:yellow;" type="checkbox"><small>Rate B (>=7 MN, 6-10 MJ, 1-2 SR)</small></a>
            <a class="btn btn-default btn-sm" style="background:salmon;" type="checkbox"><small>Rate C (>=7 MJ, 3-4 SR)</small></a>
            <a class="btn btn-default btn-sm" style="background:rgba(0,0,0,0.6); color:white;" type="checkbox"><small>Rate D (3-4 SR, >=1 KT)</small></a>
          </span>
        </td>
      </tr>
      <tr>
        <td style="background:linear-gradient(white 60%,lightgreen,lime);">		
          <?php $sqlwh = mysqli_query($konek,"SELECT * FROM area WHERE dept_area ='WH'"); $num3=1;
          while($dtwh=mysqli_fetch_array($sqlwh)){ $num3++;
            $qstsmn=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtwh[kode_area]' AND urgensi LIKE '%MN%' AND find_status!='C'");
            $qtymn = mysqli_num_rows($qstsmn); 
            $qstsmj=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtwh[kode_area]' AND urgensi LIKE '%MJ%' AND find_status!='C'");
            $qtymj = mysqli_num_rows($qstsmj); 
            $qstsr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtwh[kode_area]' AND urgensi LIKE '%SR%' AND find_status!='C'");
            $qtysr = mysqli_num_rows($qstsr); 
            $qstkt=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtwh[kode_area]' AND urgensi LIKE '%KT%' AND find_status!='C'");
            $qtykt = mysqli_num_rows($qstkt); 
            $qstbr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtwh[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C'");
            $qtybr = mysqli_num_rows($qstbr);
            $qhyg=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dtwh[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C' AND find_hygiene!=''");
            $qtyhyg = mysqli_num_rows($qhyg);
            if($qtykt>=1||$qtysr>=5){$rating="D"; $bg="background:rgba(0,0,0,0.6); color:white;";
            }elseif($qtysr>=3||$qtymj>=11){$rating="C"; $bg="background:salmon;";}elseif($qtysr>=1||$qtymj>=6||$qtymn>=7){$rating="B"; $bg="background:yellow;";}
            elseif($qtybr>=3){$rating="A"; $bg="background:lime;";}elseif($qtymn>=2||$qtymj>=1){$rating="A"; $bg="background:skyblue;";}else{$rating="A"; $bg="";}
          ?>
          <span class="col-sm-2 btn-sm btn btn-default" style="margin-bottom:5px; <?php echo $bg; ?>"><b class="btn btn-success btn-sm float-left" title="" href="#!"> <?php echo $dtwh['kode_area'];?></b> <b><?php echo $dtwh['nama_area'];?></b>
          <hr style="margin-bottom:0px;"/>
          <span class="btn btn-sm "><small><b>MINOR : <?php echo $qtymn; ?></b></small></span>
          <span class="btn btn-sm "><small><b>MAYOR : <?php echo $qtymj; ?></b></small></span><br/>
          <span class="btn btn-sm "><small><b>SERIUS : <?php echo $qtysr; ?></b></small></span>
          <span class="btn btn-sm "><small><b>KRITIS : <?php echo $qtykt; ?></b></small></span>
          <span class="btn btn-sm "><small><b>BR : <?php echo $qtybr; ?></b></small></span>
          <hr style="margin:0px;"/>
          <a title="Live Cam" style="background:maroon; color:white;" target="blank" href="<?php if($dtwh['cam_area']!=""){echo $dtwh['cam_area'];}else{ echo "#!";} ?>" class="float-left btn btn-sm btn-default"><small><i class="fa fa-video"></i></small></a>
          <a title="History" href="#!" onclick="history('<?php echo $dtwh['kode_area'];?>')" style="background:maroon; color:white;" class="float-left btn btn-sm btn-default"><small><i class="fa fa-list"></i></small></a>
          <span class="btn btn-sm "><b>RATING :  <?php echo $rating; ?></b></span>
          </span>
          <?php if($num3==6||$num3==11||$num3==16){echo "<br/>";} } ?>
        </td>
      </tr>
      <tr>
        <td>
          <span>&nbsp;
          <a title="" class="btn btn-info btn-sm" href="#!"><i class="fas fa-users"> Area Human Resource</i></a>
          </span>
          <span class="float-right">
            <a class="btn btn-default btn-sm" type="checkbox"><small>Unrated</small></a>
            <a class="btn btn-default btn-sm" style="background:skyblue;" type="checkbox"><small>Rate A (>=2 MN, >=1 MJ)</small></a>
            <a class="btn btn-default btn-sm" style="background:lime;" type="checkbox"><small>Rate A (>=3 BR)</small></a>
            <a class="btn btn-default btn-sm" style="background:yellow;" type="checkbox"><small>Rate B (>=7 MN, 6-10 MJ, 1-2 SR)</small></a>
            <a class="btn btn-default btn-sm" style="background:salmon;" type="checkbox"><small>Rate C (>=7 MJ, 3-4 SR)</small></a>
            <a class="btn btn-default btn-sm" style="background:rgba(0,0,0,0.6); color:white;" type="checkbox"><small>Rate D (3-4 SR, >=1 KT)</small></a>
          </span>
        </td>
      </tr>
      <tr>
        <td style="background:linear-gradient(white 25%,lightblue,cyan);">	
          <?php $sqlhr = mysqli_query($konek,"SELECT * FROM area WHERE dept_area ='HR'");  $num4=1;
          while($dthr=mysqli_fetch_array($sqlhr)){ $num4++;
            $qstsmn=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dthr[kode_area]' AND urgensi LIKE '%MN%' AND find_status!='C'");
            $qtymn = mysqli_num_rows($qstsmn); 
            $qstsmj=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dthr[kode_area]' AND urgensi LIKE '%MJ%' AND find_status!='C'");
            $qtymj = mysqli_num_rows($qstsmj); 
            $qstsr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dthr[kode_area]' AND urgensi LIKE '%SR%' AND find_status!='C'");
            $qtysr = mysqli_num_rows($qstsr); 
            $qstkt=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dthr[kode_area]' AND urgensi LIKE '%KT%' AND find_status!='C'");
            $qtykt = mysqli_num_rows($qstkt); 
            $qstbr=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dthr[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C'");
            $qtybr = mysqli_num_rows($qstbr);
            $qhyg=mysqli_query($konek,"SELECT * FROM finding WHERE kode_area='$dthr[kode_area]' AND urgensi LIKE '%BR%' AND find_status!='C' AND find_hygiene!=''");
            $qtyhyg = mysqli_num_rows($qhyg);
            if($qtykt>=1||$qtysr>=5){$rating="D"; $bg="background:rgba(0,0,0,0.6); color:white;";
            }elseif($qtysr>=3||$qtymj>=11){$rating="C"; $bg="background:salmon;";}elseif($qtysr>=1||$qtymj>=6||$qtymn>=7){$rating="B"; $bg="background:yellow;";}
            elseif($qtybr>=3){$rating="A"; $bg="background:lime;";}elseif($qtymn>=2||$qtymj>=1){$rating="A"; $bg="background:skyblue;";}else{$rating="A"; $bg="";}
          ?>
          <span class="col-sm-2 btn-sm btn btn-default" style="margin-bottom:5px; <?php echo $bg; ?>"><b class="btn btn-info btn-sm float-left" title="" href="#!"> <?php echo $dthr['kode_area'];?></b> <b><?php echo $dthr['nama_area'];?></b>
          <hr style="margin-bottom:0px;"/>
          <span class="btn btn-sm "><small><b>MINOR : <?php echo $qtymn; ?></b></small></span>
          <span class="btn btn-sm "><small><b>MAYOR : <?php echo $qtymj; ?></b></small></span><br/>
          <span class="btn btn-sm "><small><b>SERIUS : <?php echo $qtysr; ?></b></small></span>
          <span class="btn btn-sm "><small><b>KRITIS : <?php echo $qtykt; ?></b></small></span>
          <span class="btn btn-sm "><small><b>BR : <?php echo $qtybr; ?></b></small></span>
          <hr style="margin:0px;"/>
          <a title="Live Cam" style="background:maroon; color:white;" target="blank" href="<?php if($dthr['cam_area']!=""){echo $dthr['cam_area'];}else{ echo "#!";} ?>" class="float-left btn btn-sm btn-default"><small><i class="fa fa-video"></i></small></a>
          <a title="History" href="#!" onclick="history('<?php echo $dthr['kode_area'];?>')" style="background:maroon; color:white;" class="float-left btn btn-sm btn-default"><small><i class="fa fa-list"></i></small></a>
          <span class="btn btn-sm "><b>RATING :  <?php echo $rating; ?></b></span>
          </span>
          <?php if($num4==6||$num4==11||$num4==16){echo "<br/>";} } ?>
        </td>
      </tr>
    </tbody>
  </table>
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
  $el.animate({scrollTop: st<sb/2 ? sb : 0}, 90000, anim);
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