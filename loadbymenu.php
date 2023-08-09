<?php
include_once("connect_finger.php");
include_once("koneksi.php");
// $tgl = date('Y-m-d');
$hour = number_format(date('H'));
if($hour<=6){$day= date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));}else{
    $day=date('Y-m-d');
}
$day2= date('Y-m-d', strtotime('+1 days', strtotime($day)));
$hari = $day." 06:00:00.000"; $hari16 = $day." 17:00:00.000";
$hari18 = $day." 17:00:00.000"; $hari22 = $day." 23:00:00.000"; $hari02 = $day2." 06:00:00.000";
$fg_query = sqlsrv_query($connfinger, "SELECT [FingerPrintID] FROM [HITFPTA1].[dbo].[PersonalLog] WHERE DateTime BETWEEN '$hari' AND '$hari16' GROUP BY [FingerPrintID]");
$fg_query2 = sqlsrv_query($connfinger, "SELECT [FingerPrintID] FROM [HITFPTA1].[dbo].[PersonalLog] WHERE DateTime BETWEEN '$hari18' AND '$hari22' GROUP BY [FingerPrintID]");
$fg_query3 = sqlsrv_query($connfinger, "SELECT [FingerPrintID] FROM [HITFPTA1].[dbo].[PersonalLog] WHERE DateTime BETWEEN '$hari22' AND '$hari02' GROUP BY [FingerPrintID]");
    $code1 = 0; $code2 = 0; $code3 = 0; $code4 = 0; $code5 = 0; $code6 = 0; $code7 = 0; $code8 = 0; $code9 = 0; $code10 = 0; $code11 = 0; $code12 = 0;
    $code13 = 0; $code14 = 0; $code15 = 0; $code16 = 0; $code17 = 0; $code18 = 0; $code19 = 0; $code20 = 0; $code21 = 0; $code22 = 0; $code23 = 0; $code24 = 0; $code25 = 0; $code26 = 0;
while($datafg=sqlsrv_fetch_array($fg_query, SQLSRV_FETCH_ASSOC)){
    $querysql = mysqli_query($konek, "SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik = order_makan.nik_karyawan WHERE karyawan.kode_fg = '$datafg[FingerPrintID]' AND tgl_order='$day'"); 
    $data=mysqli_fetch_array($querysql);
    if($data['jam10']=="1"){ $code1++; }elseif($data['jam10']=="2"){ $code2++; }elseif($data['jam10']=="3"){ $code3++; }elseif($data['jam10']=="4"){ $code4++; }
    if($data['jam12']=="5"){ $code5++; }elseif($data['jam12']=="6"){ $code6++; }elseif($data['jam12']=="7"){ $code7++; }elseif($data['jam12']=="8"){ $code8++; }
    if($data['jam14']=="9"){ $code9++; }elseif($data['jam14']=="10"){ $code10++; }elseif($data['jam14']=="11"){ $code11++; }elseif($data['jam14']=="12"){ $code12++; }
}
while($datafg2=sqlsrv_fetch_array($fg_query2, SQLSRV_FETCH_ASSOC)){
    $querysql = mysqli_query($konek, "SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik = order_makan.nik_karyawan WHERE karyawan.kode_fg = '$datafg2[FingerPrintID]' AND tgl_order='$day'"); 
    $data=mysqli_fetch_array($querysql);
    if($data['jam18']=="13"){ $code13++; }elseif($data['jam18']=="14"){ $code14++; }elseif($data['jam18']=="15"){ $code15++; }elseif($data['jam18']=="16"){ $code16++; }
    if($data['jam22']=="17"){ $code17++; }elseif($data['jam22']=="18"){ $code18++; }elseif($data['jam22']=="19"){ $code19++; }elseif($data['jam22']=="20"){ $code20++; }
}
while($datafg3=sqlsrv_fetch_array($fg_query3, SQLSRV_FETCH_ASSOC)){
    $querysql = mysqli_query($konek, "SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik = order_makan.nik_karyawan WHERE karyawan.kode_fg = '$datafg3[FingerPrintID]' AND tgl_order='$day'"); 
    $data=mysqli_fetch_array($querysql);
    if($data['jam02']=="21"){ $code21++; }elseif($data['jam02']=="22"){ $code22++; }elseif($data['jam02']=="23"){ $code23++; }elseif($data['jam02']=="24"){ $code24++; }
    if($data['jam02']=="25"){ $code25++; }elseif($data['jam02']=="26"){ $code26++; }
}
    $order1 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam10='1'"); $po1 = mysqli_num_rows($order1);
    $order2 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam10='2'"); $po2 = mysqli_num_rows($order2);
    $order3 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam10='3'"); $po3 = mysqli_num_rows($order3);
    $order4 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam10='4'"); $po4 = mysqli_num_rows($order4);
    $order5 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam12='5'"); $po5 = mysqli_num_rows($order5);
    $order6 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam12='6'"); $po6 = mysqli_num_rows($order6);
    $order7 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam12='7'"); $po7 = mysqli_num_rows($order7);
    $order8 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam12='8'"); $po8 = mysqli_num_rows($order8);
    $order9 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam14='9'"); $po9 = mysqli_num_rows($order9);
    $order10 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam14='10'"); $po10 = mysqli_num_rows($order10);
    $order11 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam14='11'"); $po11 = mysqli_num_rows($order11);
    $order12 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam14='12'"); $po12 = mysqli_num_rows($order12);
    $order13 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam18='13'"); $po13 = mysqli_num_rows($order13);
    $order14 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam18='14'"); $po14 = mysqli_num_rows($order14);
    $order15 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam18='15'"); $po15 = mysqli_num_rows($order15);
    $order16 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam18='16'"); $po16 = mysqli_num_rows($order16);
    $order17 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam22='17'"); $po17 = mysqli_num_rows($order17);
    $order18 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam22='18'"); $po18 = mysqli_num_rows($order18);
    $order19 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam22='19'"); $po19 = mysqli_num_rows($order19);
    $order20 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam22='20'"); $po20 = mysqli_num_rows($order20);
    $order21 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam02='21'"); $po21 = mysqli_num_rows($order21);
    $order22 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam02='22'"); $po22 = mysqli_num_rows($order22);
    $order23 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam02='23'"); $po23 = mysqli_num_rows($order23);
    $order24 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam02='24'"); $po24 = mysqli_num_rows($order24);
    $order25 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam02='25'"); $po25 = mysqli_num_rows($order25);
    $order26 = mysqli_query($konek,"SELECT * FROM order_makan WHERE tgl_order='$day' AND jam02='26'"); $po26 = mysqli_num_rows($order26);
    $min1 = $po1?$po1-$code1:0;   $min6 = $po6?$po6-$code6:0;   $min11 = $po11?$po11-$code11:0;   $min16 = $po16?$po16-$code16:0;  $min21 = $po21?$po21-$code21:0;      $min26 = $po26?$po26-$code26:0;
    $min2 = $po2?$po2-$code2:0;   $min7 = $po7?$po7-$code7:0;   $min12 = $po12?$po12-$code12:0;   $min17 = $po17?$po17-$code17:0;  $min22 = $po22?$po22-$code22:0;   
    $min3 = $po3?$po3-$code3:0;   $min8 = $po8?$po8-$code8:0;   $min13 = $po13?$po13-$code13:0;   $min18 = $po18?$po18-$code18:0;  $min23 = $po23?$po23-$code23:0;   
    $min4 = $po4?$po4-$code4:0;   $min9 = $po9?$po9-$code9:0;   $min14 = $po14?$po14-$code14:0;   $min19 = $po19?$po19-$code19:0;  $min24 = $po24?$po24-$code24:0;   
    $min5 = $po5?$po5-$code5:0;   $min10 = $po10?$po10-$code10:0;   $min15 = $po15?$po15-$code15:0;   $min20 = $po20?$po20-$code20:0;  $min25 = $po25?$po25-$code25:0;   
?>
<a href="#!" id="menu1"><?php if($code1>0){echo $code1;}?></a>
<a href="#!" id="menu2"><?php if($code2>0){echo $code2;}?></a>
<a href="#!" id="menu3"><?php if($code3>0){echo $code3;}?></a>
<a href="#!" id="menu4"><?php if($code4>0){echo $code4;}?></a>
<a href="#!" id="menu5"><?php if($code5>0){echo $code5;}?></a>
<a href="#!" id="menu6"><?php if($code6>0){echo $code6;}?></a>
<a href="#!" id="menu7"><?php if($code7>0){echo $code7;}?></a>
<a href="#!" id="menu8"><?php if($code8>0){echo $code8;}?></a>
<a href="#!" id="menu9"><?php if($code9>0){echo $code9;}?></a>
<a href="#!" id="menu10"><?php if($code10>0){echo $code10;}?></a>
<a href="#!" id="menu11"><?php if($code11>0){echo $code11;}?></a>
<a href="#!" id="menu12"><?php if($code12>0){echo $code12;}?></a>
<a href="#!" id="menu13"><?php if($code13>0){echo $code13;}?></a>
<a href="#!" id="menu14"><?php if($code14>0){echo $code14;}?></a>
<a href="#!" id="menu15"><?php if($code15>0){echo $code15;}?></a>
<a href="#!" id="menu16"><?php if($code16>0){echo $code16;}?></a>
<a href="#!" id="menu17"><?php if($code17>0){echo $code17;}?></a>
<a href="#!" id="menu18"><?php if($code18>0){echo $code18;}?></a>
<a href="#!" id="menu19"><?php if($code19>0){echo $code19;}?></a>
<a href="#!" id="menu20"><?php if($code20>0){echo $code20;}?></a>
<a href="#!" id="menu21"><?php if($code21>0){echo $code21;}?></a>
<a href="#!" id="menu22"><?php if($code22>0){echo $code22;}?></a>
<a href="#!" id="menu23"><?php if($code23>0){echo $code23;}?></a>
<a href="#!" id="menu24"><?php if($code24>0){echo $code24;}?></a>
<a href="#!" id="menu25"><?php if($code25>0){echo $code25;}?></a>
<a href="#!" id="menu26"><?php if($code26>0){echo $code26;}?></a>

<a href="#!" id="min1"><?php if($min1>0){echo $min1;}?></a>
<a href="#!" id="min2"><?php if($min2>0){echo $min2;}?></a>
<a href="#!" id="min3"><?php if($min3>0){echo $min3;}?></a>
<a href="#!" id="min4"><?php if($min4>0){echo $min4;}?></a>
<a href="#!" id="min5"><?php if($min5>0){echo $min5;}?></a>
<a href="#!" id="min6"><?php if($min6>0){echo $min6;}?></a>
<a href="#!" id="min7"><?php if($min7>0){echo $min7;}?></a>
<a href="#!" id="min8"><?php if($min8>0){echo $min8;}?></a>
<a href="#!" id="min9"><?php if($min9>0){echo $min9;}?></a>
<a href="#!" id="min10"><?php if($min10>0){echo $min10;}?></a>
<a href="#!" id="min11"><?php if($min11>0){echo $min11;}?></a>
<a href="#!" id="min12"><?php if($min12>0){echo $min12;}?></a>
<a href="#!" id="min13"><?php if($min13>0){echo $min13;}?></a>
<a href="#!" id="min14"><?php if($min14>0){echo $min14;}?></a>
<a href="#!" id="min15"><?php if($min15>0){echo $min15;}?></a>
<a href="#!" id="min16"><?php if($min16>0){echo $min16;}?></a>
<a href="#!" id="min17"><?php if($min17>0){echo $min17;}?></a>
<a href="#!" id="min18"><?php if($min18>0){echo $min18;}?></a>
<a href="#!" id="min19"><?php if($min19>0){echo $min19;}?></a>
<a href="#!" id="min20"><?php if($min20>0){echo $min20;}?></a>
<a href="#!" id="min21"><?php if($min21>0){echo $min21;}?></a>
<a href="#!" id="min22"><?php if($min22>0){echo $min22;}?></a>
<a href="#!" id="min23"><?php if($min23>0){echo $min23;}?></a>
<a href="#!" id="min24"><?php if($min24>0){echo $min24;}?></a>
<a href="#!" id="min25"><?php if($min25>0){echo $min25;}?></a>
<a href="#!" id="min26"><?php if($min26>0){echo $min26;}?></a>
