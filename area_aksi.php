<?php
include 'koneksi.php'; 
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
if(isset($_POST['simpan'])){
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

		$sql = "INSERT INTO area (`id_area`, `kode_area`, `nama_area`, `type_area`, `dept_area`, `cam_area`) VALUES ('','{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}','{$strs[4]}')";
		if(!mysqli_query($hygiene_conn,$sql)){
			echo 'excel error'; header("Refresh:1; url=area.php");
		}else{
			header("location:area.php?berhasil=$berhasil");
		}
	}
}
?>