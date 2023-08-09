<?php
include_once("connect_finger.php");
include_once("koneksi.php");
// $tgl = date('Y-m-d');
$hour = number_format(date('H'));
if($hour<=6){$day= date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d'))));}else{
    $day=date('Y-m-d');
}
$fg_query = sqlsrv_query($connfinger, "SELECT TOP (1) [PersonalLogID]
,[TerminalID]
,[FingerPrintID]
,[DateLog]
,[TimeLog]
,[VerifyMode]
,[FunctionKey]
,[Edited]
,[UserName]
,[FlagAbsence]
,[DateTime]
,[EmployeeStatus]
,[FunctionKeyEdited]
,[PersonalLogStatus] FROM [HITFPTA1].[dbo].[PersonalLog] ORDER BY [DateTime] DESC");
$datafg=sqlsrv_fetch_array($fg_query);
$querysql = mysqli_query($konek, "SELECT * FROM karyawan LEFT JOIN order_makan ON karyawan.nik = order_makan.nik_karyawan WHERE karyawan.kode_fg = '$datafg[FingerPrintID]' AND tgl_order='$day'"); 
$data=mysqli_fetch_array($querysql); $code=NULL;
if($hour>=7&&$hour<=16){  
    if($data['jam10']>0){$code = $data['jam10'];}
    elseif($data['jam12']>0){$code = $data['jam12'];}
    elseif($data['jam14']>0){$code = $data['jam14'];}
}elseif($hour>=17&&$hour<=20){   $code = $data['jam18'];
}elseif($hour>=21&&$hour<=23){   $code = $data['jam22'];
}elseif($hour>=0&&$hour<=6){  $code = $data['jam02']; }
$menuquery = mysqli_query($konek,"SELECT * FROM menu_makan WHERE tgl_menu='$day' AND jenis_menu='UTAMA' AND kode_menu='$code'"); $menu = mysqli_fetch_array($menuquery);
if($menu['judul_menu']){echo $menu['judul_menu'];}else{ echo "BELUM ORDER !!!";}
?>