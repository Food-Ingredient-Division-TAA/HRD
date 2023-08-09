<?php
include_once("connect_finger.php");
include_once("koneksi.php");
// $day = date('Y-m-d');
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
$data=mysqli_fetch_array($querysql);
if($hour>=6&&$hour<=10){   // echo $data['jam10']; 
    echo "10:00 WIB";
}elseif($hour>=11&&$hour<=12){   echo "12:00 WIB";
}elseif($hour>=13&&$hour<=15){   echo "14:00 WIB";
}elseif($hour>=17&&$hour<=20){   echo "18:00 WIB";
}elseif($hour>=21&&$hour<=23){   echo "22:00 WIB";
}elseif($hour>=1&&$hour<=3){   echo "02:00 WIB";
}else{ echo "-";}
?>