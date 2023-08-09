<?php
include('configprod.php');
include('connect.php');
// $page ="view_smpl.php";
$page ="video_player3.php";
$sec = "300";
$year = substr(date('Y'),2,2); $yskr=0; $pcs=0; $stdbruto=0; $sumflv=NULL;
$sql = mysqli_query($konek, "SELECT `id_daily`, `tgl_daily`, `dept_produk`, `jns_produk`, `shift_daily`, `nik_karyawan`, `jns_mesin`, `nomor_mesin`, `rpm_mesin`, `kode_material`, `jam_planning`, 
SUM(gk_output) AS gk, SUM(`jam_actual`) AS kerja ,SUM(`act_output`) AS act, SUM(`std_output`) AS std, (SUM(`act_output`)/SUM(`std_output`)*100)  AS achiv, `ket_ouput`, SUM(`point`) AS poin
FROM daily_output WHERE dept_produk='Minyak' AND nik_karyawan!='' AND YEAR(tgl_daily) = '20$year' GROUP BY nik_karyawan ORDER BY poin DESC LIMIT 1");
$data=mysqli_fetch_array($sql); 
$op = mysqli_query($konek,"SELECT * FROM karyawan WHERE nik='$data[nik_karyawan]'"); $kry = mysqli_fetch_array($op); 
$yretur = mysqli_query($konek,"SELECT * FROM qc_skr_komplain  LEFT JOIN `qc_skr` ON `qc_skr_komplain`.`no_skr`=`qc_skr`.`no_skr` LEFT JOIN `material` ON `qc_skr_komplain`.`kode_material`=`material`.`kode_material` WHERE material.dept_material='Minyak' AND nik_karyawan='$data[nik_karyawan]' AND nik_karyawan!='' AND SUBSTR(kode_batch,7,2) ='$year' AND YEAR(tgl_skr) = '20$year'");
while($ydretur=mysqli_fetch_array($yretur)){  $yskr += $ydretur['qty_komplain']; }
$flv = mysqli_query($konek,"SELECT * FROM daily_output WHERE dept_produk='Minyak' AND nik_karyawan='".$data['nik_karyawan']."' AND YEAR(tgl_daily) = '20$year' GROUP BY kode_material");
while($dflv = mysqli_fetch_array($flv)){
  $mtr = mysqli_query($konek, "SELECT * FROM `material` WHERE kode_material = '".$dflv['kode_material']."'"); $flv1 = mysqli_fetch_array($mtr);
  $digistd = sqlsrv_query($conndigi,"SELECT * FROM [idmp_palembang].[dbo].[idmp_standart] WHERE material_id = '$dflv[kode_material]'"); $datatd=sqlsrv_fetch_array($digistd, SQLSRV_FETCH_ASSOC);
  $stdbruto += number_format($datatd['std_total'],2);
  $sumflv.=$flv1['nick_material'].", ";
}
$pcs = $data['gk']?$data['gk']*1000/$stdbruto:0;
?>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="refresh" content="<?php echo $sec;?>; URL='<?php echo $page;?>'">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/icbplogo.png">

    <title>LEADERBOARD | MINYAK</title>

    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
<style>
body{
  background-repeat:no-repeat; 
  background-image:linear-gradient(lightblue 10%,cyan,lime);
  /* background-image:url(assets/img/indofood-cbp.png);  */
  background-position:center; 
  font-family:Tahoma;
}
.breadcrumb{ border: solid 4px ;  border-radius:0.5em; padding:0px;
  box-shadow: 3px 5px rgba(0,0,0,0.2); 
  /* text-shadow:1px 1px rgba(0,0,0,0.8); */
  border-color:linear-gradient(pink,yellow,lightgreen); 
}
.box{
  font-size:18px; font-weight:bold; border:1px solid #000; border-radius:5px; box-shadow:2px 1px rgba(0,0,0,0.4); 
  padding:5px 6px 9px 6px; color:blue; background:#FFF;
  background-image:linear-gradient(white 5%,rgba(120,230,150,0.8),lime);
}
.box3{
  font-size:18px; font-weight:bold; border:1px solid #000; border-radius:5px; box-shadow:2px 1px rgba(0,0,0,0.4); 
  padding:14px 6px 15px 6px; color:blue; background:#FFF;
  background-image:linear-gradient(white 5%,rgba(120,230,150,0.8),lime);
}
.box4{
  font-size:18px; font-weight:bold; border:1px solid #000; border-radius:5px; box-shadow:2px 1px rgba(0,0,0,0.4); 
  padding:11px 6px 12px 6px; color:blue; background:#FFF;
  background-image:linear-gradient(white 10%,rgba(120,230,150,0.8),lime);
}
.number{
  float:right; border:3px solid #000; padding:6px; margin:-15px -18px 10px 10px; font-weight:bold; border-radius:100%;
  font-size:24px; color:blue; 
  background-image:linear-gradient(white 10%,rgba(120,230,150,0.8),rgba(120,230,150,1));
}
.number2{
  float:right; border:3px solid #000; padding:6px; margin:-15px -18px 10px 10px; font-weight:bold; border-radius:100%;
  font-size:34px; color:blue; 
  background-image:linear-gradient(white 10%,silver,white);
}
.number3{
  float:right; border:3px solid #000; padding:6px; margin:-15px -18px 10px 10px; font-weight:bold; border-radius:100%;
  font-size:28px; color:blue; 
  background-image:linear-gradient(white 10%,rgba(255,150,90,0.5),rgba(255,150,90,1));
}
#judul1{ display:block; font-weight:bold; background:lime; padding:2px; margin:0px; font-size:20px; text-align:center;}
#judul2{ display:none; font-weight:bold; background:cyan; padding:2px; margin:0px; font-size:20px; text-align:center;}
#judul3{ display:none; font-weight:bold; background:rgba(255,0,255,0.6); padding:2px; margin:0px; font-size:20px; text-align:center;}
</style>
</head>
<body class="rolling">
<nav class="navbar navbar-default" style="background:gold; color:#000000; font-weight:bold; ">
      <a style="color:#000000;" class="navbar-brand" href="#!"><span><img width="160" src="assets/img/indofood-cbp.png"/></span></a>
    <span style="position:absolute; margin:auto; padding:15px; font-size:20px;">PACKING MINYAK <?php echo date('Y'); ?></span>
    <span style="float:right; padding:15px; font-size:20px;">LEADERBOARD <span class="jam"></span></span>
  <div class="container">
    <div class="navbar-header">
    </div>
  </div>
</nav>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-9">
        <b style="font-size:18px;"><?php echo format_indo(date('Y-m-d')); ?> (
    <?php 
      $now = date('Y-m-d');
      $now = date('Y-m-d', strtotime($now));
      $sql = mysqli_query($konek, "SELECT * FROM week_table WHERE DATE(NOW()) BETWEEN tgl_awal AND tgl_akhir");
      $result = mysqli_fetch_array($sql);
        echo "WEEK ".substr($result['title_week'],5); $week= $result['title_week'];
    ?> ) </b>
      </div><!-- /.col -->
      <div class="col-sm-3">
        <div class="breadcrumb float-sm-right">
            <div id="judul1">OUTPUT THIS YEAR</div>
            <!-- <div id="judul2">LAST MONTH</div>
            <div id="judul3">LAST WEEK</div> -->
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="card-body table-responsive p-0" style="height:645px;">
<section class="content">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-3">
        <div class="breadcrumb float-sm-right" style="text-align:center; text-transform:uppercase; font-weight:bold; font-size:20px; color:#000000; background:gold;">
          <span style="font-size:26px;">TOP 1 OPERATOR</span><hr/>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img width="200" height="200" src="http://10.126.24.221/FID-PRODUCTION/assets/img/upload/<?php if( $kry['photo']){echo $kry['photo'];}else{ echo "user.png";} ?>" class="img-circle elevation-2 top1poto" alt="User Image">
            </div>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span class="top1name"><?php echo $kry['nama_karyawan'];?></span>
            <p class="top1nik" style="font-size:18px; color:#04D;"><?php echo $kry['nik'];?></p><hr/>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span>OUTPUT / ACHIVEMENT</span>
            <p class="top1aout" style="font-size:18px; color:#04D;"><?php echo number_format($data['act'])." Pcs";?></p>
            <p class="top1achv" style="font-size:28px; border:2px solid; text-shadow:1px 1px rgba(0,0,0,0.5); border-radius:5px; color:#090;"><?php echo number_format($data['achiv'],2)."%";?></p>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span>PACKING REJECT (GK)</span>
            <p class="top1gk" style="font-size:18px; color:#04D;"><?php echo number_format($pcs)." Pcs";?></p>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span>PRODUCT RETUR</span>
            <p class="top1retur" style="font-size:18px; color:#04D;"><?php echo number_format($yskr)." Pcs";?></p>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span>TOTAL POINT</span>
            <p class="top1poin" style="font-size:18px; color:#04D;"><?php echo number_format($data['poin']);?></p>
          </div>
        </div>
      </div><!-- /.col -->
      <?php 
        $num=1;
      $sql = mysqli_query($konek, "SELECT `id_daily`, `tgl_daily`, `dept_produk`, `jns_produk`, `shift_daily`, `nik_karyawan`, `jns_mesin`, `nomor_mesin`, `rpm_mesin`, `kode_material`, `jam_planning`, SUM(gk_output) AS gk, SUM(`jam_actual`) AS kerja ,SUM(`act_output`) AS act, SUM(`std_output`) AS std, (SUM(`act_output`)/SUM(`std_output`)*100)  AS achiv, `ket_ouput`, SUM(`point`) AS poin
      FROM daily_output WHERE dept_produk='Minyak' AND nik_karyawan!='' AND YEAR(tgl_daily) = '20$year' GROUP BY nik_karyawan ORDER BY poin DESC");
        while($row=mysqli_fetch_array($sql)){    $gkpcs=0;   $stdbruto=0; $sumflv=""; $yskr=0;
          $op = mysqli_query($konek,"SELECT * FROM karyawan WHERE nik='$row[nik_karyawan]'"); $kry = mysqli_fetch_array($op); 
          $yretur = mysqli_query($konek,"SELECT * FROM qc_skr_komplain  LEFT JOIN `qc_skr` ON `qc_skr_komplain`.`no_skr`=`qc_skr`.`no_skr` LEFT JOIN `material` ON `qc_skr_komplain`.`kode_material`=`material`.`kode_material` WHERE material.dept_material='Minyak' AND nik_karyawan='$row[nik_karyawan]' AND nik_karyawan!='' AND SUBSTR(kode_batch,7,2) ='$year' AND YEAR(tgl_skr) = '20$year'");
          while($ydretur=mysqli_fetch_array($yretur)){  $yskr += $ydretur['qty_komplain']; }
          $flv = mysqli_query($konek,"SELECT * FROM daily_output WHERE dept_produk='Minyak' AND nik_karyawan='".$row['nik_karyawan']."' AND YEAR(tgl_daily) = '20$year' GROUP BY kode_material");
          while($dflv = mysqli_fetch_array($flv)){
              $mtr = mysqli_query($konek, "SELECT * FROM `material` WHERE kode_material = '".$dflv['kode_material']."'"); $flv1 = mysqli_fetch_array($mtr);
              $digistd = sqlsrv_query($conndigi,"SELECT * FROM [idmp_palembang].[dbo].[idmp_standart] WHERE material_id = '$dflv[kode_material]'"); $datatd=sqlsrv_fetch_array($digistd, SQLSRV_FETCH_ASSOC);
              $stdbruto += number_format($datatd['std_total'],2);
              $sumflv.=$flv1['nick_material'].", ";
          } $gkpcs = $row['gk']?$row['gk']*1000/$stdbruto:0;
          if($num=="2"){$w="60"; $style="font-size:19px; background:rgba(250,250,250,1);";
          }elseif($num=="3"){$w="55";  $style="font-size:18px; background:rgba(255,150,90,0.8);";
          }elseif($row['achiv']>=95&& $num>3){$w="50";  $style="font-size:16px; background:rgba(120,230,150,0.8);";
          }elseif($row['achiv']>=85){$w="50";  $style="font-size:16px; background:rgba(255,255,0,0.8);";
          }elseif($row['achiv']<85){$w="50";  $style="font-size:16px; color:#FFF; background:rgba(255,0,0,0.8);";
          }else{$w="40"; $style="font-size:16px; background:rgba(120,230,150,0.8);";}
          echo "<input type='hidden' id='namaop".$num."' value='".$kry['nama_karyawan']."'/>";
      ?>
      <div class="col-sm-<?php if($num<=10){echo "9";}else{echo "12";} ?>" style="<?php if($num=="1"){ echo "display:none;";} ?> white-space:nowrap;">
        <div class="breadcrumb float-sm-right" style="<?php echo $style; ?>">
          <div class="image"> <span class="number<?php if($num<=3){echo $num;} ?>"><?php echo "#".$num++; ?></span>
            <img width="<?php echo $w; ?>" height="<?php echo $w; ?>" id="photo<?php echo $num; ?>" src="http://10.126.24.221/FID-PRODUCTION/assets/img/upload/<?php if( $kry['photo']){echo $kry['photo'];}else{ echo "user.png";} ?>" class="img-circle elevation-2" alt="User Image"/>           
            <span id="name<?php echo $num; ?>"><b style="font-size:<?php if($num<=3){echo "20";}else{echo "18";} ?>px;"><?php echo $kry['nama_karyawan'] ?></b></span> 
             <small id="nik<?php echo $num; ?>"><?php echo "<b>(".$row['poin']." Point)</b>"; ?></small>
            <span><b style="font-size:<?php if($num<=3){echo "20";}else{echo "18";} ?>px;">: REJECT(GK) </b></span><span id="gk<?php echo $num; ?>" class="box<?php if($num<=4){echo $num;} ?>"><?php echo number_format($gkpcs)." Pcs"; ?></span>
            <span><b style="font-size:<?php if($num<=3){echo "20";}else{echo "18";} ?>px;">RETUR </b></span><span id="rtr<?php echo $num; ?>" class="box<?php if($num<=4){echo $num;} ?>"><?php echo number_format($yskr)." Pcs"; ?></span>
            <span><b style="font-size:<?php if($num<=3){echo "20";}else{echo "18";} ?>px;">ACHIV <small id="out<?php echo $num; ?>"><?php echo "<b>(".number_format($row['act'])." Pcs)</b>"; ?></small> </b></span>
            <span id="achv<?php echo $num; ?>" class="box<?php if($num<=4){echo $num;} ?>"><?php echo number_format($row['achiv'],2)."%"; ?></span>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          </div>
        </div>
      </div><!-- /.col -->
      <?php
        }
      ?>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<div>

<footer class="footer">
  <div class="container">
    <p class="text-muted"><a href="#!" target="_blank">INDOFOOD CBP SM &copy; FOOD INGREDIENTS DIVISION</a> 2021</p>
  </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<style>
.backgroundRed{background :yellow; }
#color1 { padding:5px; margin:3px; border:1px solid #000; border-radius:5px;
   font-weight:bold; text-align:center; color:#000;
	-webkit-transition :background 1.0s ease-in-out;
	-ms-transition :background 1.0s ease-in-out;
	transition :background 1.0s ease-in-out;
}
#color2 { padding:5px; margin:3px; border:1px solid #000; border-radius:5px;
   font-weight:bold; text-align:center; color:#000;
	-webkit-transition :background 1.0s ease-in-out;
	-ms-transition :background 1.0s ease-in-out;
	transition :background 1.0s ease-in-out;
}
#color3 { padding:5px; margin:3px; border:1px solid #000; border-radius:5px;
   font-weight:bold; text-align:center; color:#000;
	-webkit-transition :background 1.0s ease-in-out;
	-ms-transition :background 1.0s ease-in-out;
	transition :background 1.0s ease-in-out;
}
</style>
<script>
var $div2blink = $("#color1");
var backgroundInterval = setInterval(function(){
	$div2blink.toggleClass("backgroundRed");
}, 1000)
setInterval(myTimer, 1000);
function myTimer(){
  const date = new Date();
  document.getElementById("demo").innerHtml = date.toLocaleTimeString();
}
function jam() {
var time = new Date(),
	hours = time.getHours(),
	minutes = time.getMinutes(),
	seconds = time.getSeconds();
document.querySelectorAll('.jam')[0].innerHTML ="| "+ harold(hours) + " : " + harold(minutes) + " : " + harold(seconds);
function harold(standIn) {
	if (standIn < 10) {
		standIn = '0' + standIn
	}
	return standIn;
	}
}
setInterval(jam, 1000);

var interval1 = setInterval(function(){
  var jud1 = document.getElementById('judul1');
  var jud2 = document.getElementById('judul2');
  var jud3 = document.getElementById('judul3');
  if(jud1.style.display=='block'){ jud1.style.display ='none';    jud2.style.display ='block';    jud3.style.display ='none';
  }else if(jud2.style.display=='block'){    jud1.style.display ='none';    jud2.style.display ='none';    jud3.style.display ='block';
  }else{ jud1.style.display ='block';    jud2.style.display ='none';    jud3.style.display ='none';
  }
}, 10000);

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

// function loadOut(){
//   $('.top1poto').load('load_year/getopname.php #photo', function(){
//       var lht = $(this).text();
//       $(this).attr('src',lht);
//   });
//   $('.top1name').load('load_year/getopname.php #name', function(){
//     $(this).text();
//   });
//   $('.top1nik').load('load_year/getopnik.php', function(){
//     $(this).text();
//   });
//   $('.top1aout').load('load_year/getopout.php', function(){
//     $(this).text();
//   });
//   $('.top1achv').load('load_year/getopachv.php', function(){
//     $(this).text();
//   });
//   $('.top1gk').load('load_year/getopgk.php', function(){
//     $(this).text();
//   });
//   $('.top1retur').load('load_year/getopretur.php', function(){
//     $(this).text();
//   });
//   $('.top1poin').load('load_year/getopname.php #point', function(){
//     $(this).text();
//   });
//   $('.yearoutput').load('load_year/output.php', function(){
//     $(this).text();
//   });
// } loadOut();
// setInterval(function(){
//   loadOut()
// }, 10000);

// function loadArray(){
//   for(i=1;i<=70;i++){
//     $('#photo'+i).load('load_year/opnameray.php #poto'+i, function(){
//       var gbr = $(this).text();
//       $(this).attr('src',gbr);
//     });
//     $('#name'+i).load('load_year/opnameray.php #nama'+i, function(){
//       $(this).text();
//     });
//     $('#nik'+i).load('load_year/opnameray.php #point'+i, function(){
//       $(this).text();
//     });
//     $('#gk'+i).load('load_year/opnameray.php #rject'+i, function(){
//       $(this).text();
//     });
//     $('#rtr'+i).load('load_year/opnameray.php #rtr'+i, function(){
//       $(this).text();
//     });
//     $('#out'+i).load('load_year/opnameray.php #out'+i, function(){
//       $(this).text();
//     });
//     $('#achv'+i).load('load_year/opnameray.php #ach'+i, function(){
//       $(this).text();
//     });
//   }
// } loadArray();
// setInterval(function(){
//   loadArray()
// }, 10000);

</script>
