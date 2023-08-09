<?php
include_once("connect_finger.php");
include_once("koneksi.php");
$day = date('Y-m-d');
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
$querysql = mysqli_query($konek, "SELECT * FROM karyawan WHERE kode_fg = '$datafg[FingerPrintID]'"); $data=mysqli_fetch_array($querysql);
if(isset($data['nama_karyawan'])){ echo $data['nama_karyawan'];}else{ echo "ID Belum Terdaftar";}
?>