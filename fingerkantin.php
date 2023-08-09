<?php
// include('configprod.php');
include('connect.php');
include('connect_finger.php');
include('koneksi.php');
$page ="fingerkantin.php";
$sec = "3600";
$num=1;
$hour = number_format(date('H'));
if(isset($_GET['day'])){ $tgl = $_GET['day'];}else{
    if($hour<=6){$tgl= date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));}else{
        $tgl=date('Y-m-d');
    }
}
$jam = date('H:i:s');
?>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="refresh" content="<?php echo $sec;?>;URL='<?php echo $page;?>'">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/icbplogo.png">

    <title>HRD | KANTIN</title>

    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
<style>
body{
  background-repeat:no-repeat;
  background-image:linear-gradient(Paleturquoise 10%, lightyellow, skyblue);
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
<nav class="navbar navbar-default" style="background:cyan; color:#000000; font-weight:bold; ">
      <a style="color:#000000;" class="navbar-brand" href="#!"><span><img width="160" src="assets/img/indofood-cbp.png"/></span></a>
    <span style="position:absolute; margin:auto; padding:15px; font-size:20px;">HRD <?php echo date('Y'); ?></span>
    <span style="float:right; padding:15px; font-size:20px;">KANTIN-FIDTAA <span class="jam"></span></span>
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
            <div id="judul1"><i class="fas fa-hamburger text-pink"> </i> TODAY'S MENU</div>
            <!-- <div id="judul2">LAST MONTH</div>
            <div id="judul3">LAST WEEK</div> -->
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="card-body table-responsive p-0" >
<section class="content">
  <div class="container-fluid">
      <div class="col-sm-3">
        <div class="breadcrumb" style="text-align:center; text-transform:uppercase; font-weight:bold; font-size:24px; color:#000000; background:gold;">
          <span style="font-size:26px;">TAKE YOUR ORDER</span><hr/>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img width="200" height="200" src="http://10.126.24.221/FID-PRODUCTION/assets/img/upload/<?php  echo "user.png"; ?>" class="img-circle elevation-2 top1poto" alt="User Image">
            </div>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span class="top1name" id="nama_karyawan" style="color:deeppink;"></span>
            <p id="departemen" style="font-size:18px; color:#04D;"></p><hr/>
          </div>
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <span>WAKTU MAKAN SEKARANG</span>
            <p id="jamorder" style="font-size:20px; color:deeppink;"></p>
            <p id="judul_menu" style="font-size:36px; border:2px solid; text-shadow:1px 1px rgba(0,0,0,0.5); background:lime; border-radius:5px;  color:deeppink;"></p>
            <p id="takeout" style="font-size:18px; color:#04D;"></p>
          </div>
        </div>
      </div>
        <div class="col-sm-9" style="white-space:nowrap;  float:right;">
          <div class="breadcrumb" style="font-size:16px; ">
            <table class="float-sm-right table table-bordered table-sm table-head-fixed text-nowrap display12" id="scroll" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="background:lime;"><center>KODE</center></th>
                  <th style="background:lime;"><center>MENU</center></th>
                  <th style="background:lime;"><center>WAKTU MAKAN</center></th>
                  <th style="background:lime;"><center>ORDER</center></th>
                  <th style="background:lime;"><center>TAKE OUT</center></th>
                  <th style="background:lime;"><center>SISA ORDER</center></th>
                  <th style="background:lime;"><center>RATING</center></th>
                </tr>
              </thead>
              <tbody>
              <?php  $no=1;
              if($hour>=6&&$hour<=19){
                $allmenu = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND quota_menu>0 AND kode_menu <= 16 ORDER BY kode_menu ASC");
              }else{
                $allmenu = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$tgl' AND jenis_menu='UTAMA' AND quota_menu>0 AND kode_menu >= 17 ORDER BY kode_menu ASC");
              } $arraypo = NULL;
                while($recmenu=mysqli_fetch_array($allmenu)){ $jam=NULL; $allpo =0;
                  $order10 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam10='$recmenu[kode_menu]'"); $po10 = mysqli_num_rows($order10);
                  $order12 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam12='$recmenu[kode_menu]'"); $po12 = mysqli_num_rows($order12);
                  $order14 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam14='$recmenu[kode_menu]'"); $po14 = mysqli_num_rows($order14);
                  $order18 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam18='$recmenu[kode_menu]'"); $po18 = mysqli_num_rows($order18);
                  $order22 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam22='$recmenu[kode_menu]'"); $po22 = mysqli_num_rows($order22);
                  $order02 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$tgl' AND jam02='$recmenu[kode_menu]'"); $po02 = mysqli_num_rows($order02);
                  $allpo = $po10+$po12+$po14+$po18+$po22+$po02;
                  $star1 = "&bigstar;"; $star2 = "&bigstar;&bigstar;"; $star3 = "&bigstar;&bigstar;&bigstar;"; $star4 = "&bigstar;&bigstar;&bigstar;&bigstar;"; 
                  $star5 = "&bigstar;&bigstar;&bigstar;&bigstar;&bigstar;";
                  if($recmenu['kode_menu']>=1&&$recmenu['kode_menu']<=4){$jam ="10:00 WIB";}
                  elseif($recmenu['kode_menu']>=4&&$recmenu['kode_menu']<=8){$jam ="12:00 WIB";}
                  elseif($recmenu['kode_menu']>=7&&$recmenu['kode_menu']<=12){$jam ="14:00 WIB";}
                  elseif($recmenu['kode_menu']>=10&&$recmenu['kode_menu']<=16){$jam ="18:00 WIB";}
                  elseif($recmenu['kode_menu']>=13&&$recmenu['kode_menu']<=20){$jam ="22:00 WIB";}
                  elseif($recmenu['kode_menu']>=16&&$recmenu['kode_menu']>=21){$jam ="02:00 WIB";}
                  if($no%2==0){$bg="rgb(50, 205, 50, 0.2)";}else{$bg=NULL;}
              ?>
                <tr>
                  <td style="background:<?php echo $bg;?>;" align="center"><?php echo $recmenu['kode_menu']; ?></td>
                  <td style="background:<?php echo $bg;?>;"><?php echo $recmenu['judul_menu']; ?></td>
                  <td style="background:<?php echo $bg;?>;" align="center"><?php echo $jam; ?></td>
                  <!-- <td style="background:<?php echo $bg;?>;" align="center"><?php echo $recmenu['quota_menu']; ?></td> -->
                  <td style="background:<?php echo $bg;?>;" align="center"><?php if($allpo>0){echo $allpo;} ?> <input type="hidden" id="order<?php echo $recmenu['kode_menu']; ?>" value="<?php echo $allpo; ?>"/></td>
                  <td style="background:<?php echo $bg;?>;" align="center"><b id="take<?php echo $recmenu['kode_menu']; ?>"></b></td>
                  <td style="background:<?php echo $bg;?>;" align="center"><b id="sisa<?php echo $recmenu['kode_menu']; ?>"></b></td>
                  <td style="background:<?php echo $bg;?>;" align="center">
                  <?php if($allpo>=90){?><span style="font-size:120%;color:blue;"><?php echo $star5; ?></span> <?php } 
                  elseif($allpo>=70){?><span style="font-size:120%;color:blue;"><?php echo $star4; ?></span> <?php } 
                  elseif($allpo>=50){?><span style="font-size:120%;color:blue;"><?php echo $star3; ?></span> <?php }
                  elseif($allpo>=30){?><span style="font-size:120%;color:blue;"><?php echo $star2; ?></span> <?php }
                  elseif($allpo>=10){?><span style="font-size:120%;color:blue;"><?php echo $star1; ?></span> <?php }
                  else{?><span style="font-size:120%;color:blue;"><?php echo ""; ?></span> <?php } ?>
                  </td>
                </tr>
              <?php
                $no++;} ?>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
        </div>
  </div><!-- /.container-fluid -->
</section>
<div>

<footer class="footer">
  <div class="container">
    <p class="text-muted"><a href="#!" target="_blank">INDOFOOD CBP SM &copy; FOOD INGREDIENTS DIVISION</a> 2023</p>
  </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>


<script>

setInterval(jam, 1000);
function notifName(){
    $('#nama_karyawan').load('loadfg_name.php', function(){ $(this).text();
    });
} notifName();
setInterval(function(){
  notifName()
}, 1000);
function notifUnit(){
    $('#departemen').load('loadfg_unit.php', function(){ $(this).text();
    });
} notifUnit();
setInterval(function(){
  notifUnit()
}, 1000);
function notifJam(){
    $('#jamorder').load('loadfg_jam.php', function(){ $(this).text();
    });
} notifJam();
setInterval(function(){
  notifJam()
}, 1000);
function notifMenu(){
    $('#judul_menu').load('loadfg_menu.php', function(){ $(this).text();
    });
} notifMenu();
setInterval(function(){
  notifMenu()
}, 1000);
function notifTake(){
    $('#takeout').load('loadfg_take.php', function(){ $(this).text();
    });
} notifTake();
setInterval(function(){
  notifTake()
}, 1000);
function menuTake(){
  for(let i=1; i<=26; i++){
    $('#take'+i).load('loadbymenu.php #menu'+i, function(){ $(this).text();  });
    $('#sisa'+i).load('loadbymenu.php #min'+i, function(){ $(this).text();  });
  }
} menuTake();
setInterval(function(){
  menuTake()
}, 1000);

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

</script>
