<?php
include 'koneksihr.php'; 
include "conn_hygiene.php";
require_once 'PHPExcel/PHPExcel.php';
require_once 'PHPExcel/PHPExcel/IOFactory.php';
require_once 'PHPExcel/PHPExcel/Reader/Excel5.php';

$objReader = PHPExcel_IOFactory::createReader('excel5');  //use Excel5 for 2003 format

//$excelpath='tmp_mesin.xls'; //The name of the excel file
$rand = rand();
$ekstensi =  '.xls';
$filename = $_FILES['template']['name'];
$ukuran = $_FILES['template']['size'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if(isset($_POST['upload'])){
	move_uploaded_file($_FILES['template']['tmp_name'], 'tmp/'.$rand.'.xls');
	$excelpath = 'tmp/'.$rand.'.xls';
	$objPHPExcel = $objReader->load($excelpath);

	$sheet = $objPHPExcel->getSheet(0);

	$highestRow = $sheet->getHighestRow(); // Get the total number of rows

	$highestColumn = $sheet->getHighestColumn(); //Get the total number of columns
	$berhasil = 0;
	for($j=2;$j<=$highestRow;$j++){
		$str="";
		for($k='A';$k<=$highestColumn;$k++){
			$str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'|*|';//Read cell
		}
		$str=mb_convert_encoding($str,'utf-8','auto');//
		$strs = explode("|*|",$str);
		$berhasil++;
		$tggl = substr($strs[4],6,4)."-".substr($strs[4],3,2)."-".substr($strs[4],0,2);
		$sql = "INSERT INTO `lemburan`(`id_lembur`, `no_spl`, `nik_spl`, `nama_spl`, `posisi_spl`, `tgl_spl`, `jam_start`, `jam_end`, `lintas_hari`, `stts_spl`) 
		VALUES ('','{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}','$tggl','{$strs[5]}','{$strs[6]}','{$strs[7]}','1')";
		if(!mysqli_query($konekhr,$sql)){
			echo 'excel error'; header("Refresh:1; url=spl.php");
		}else{
			header("location:spl.php?berhasil=$berhasil");
		}
	}
}
?>