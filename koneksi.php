<?php
//variabel koneksi
$konek = mysqli_connect("localhost","root","@candra27","production");

if(!$konek){
	echo "Koneksi Database Gagal...!!!";
}
 $timeout = 45; // setting timeout dalam menit
 $logout = "login.php"; // redirect halaman logout
 $timeout = $timeout * 60; // menit ke detik
 if(isset($_SESSION['start_session'])){
 $elapsed_time = time()-$_SESSION['start_session'];
	if($elapsed_time >= $timeout){
	session_destroy();
	echo "<script type='text/javascript'>alert('Sesi telah berakhir');window.location='$logout'</script>";
	}
 }
 
 $_SESSION['start_session']=time();

date_default_timezone_set('Asia/Jakarta');
function format_indo($date){
    date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
    $Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    
    // pemisahan tahun, bulan, hari, dan waktu
    $tahun = substr($date,0,4);
    $bulan = substr($date,5,2);
    $tgl = substr($date,8,2);
    $waktu = substr($date,11,5);
    $hari = date("w",strtotime($date));
    $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu;
	if($result){
	return $result;
	}
  }
function namaBulan($angka){ 
	switch ($angka) {
		case '1':
			$bulan = "Januari";
			break;
		case '2':
			$bulan = "Februari";
			break;
		case '3':
			$bulan = "Maret";
			break;
		case '4':
			$bulan = "April";
			break;
		case '5':
			$bulan = "Mei";
			break;
		case '6':
			$bulan = "Juni";
			break;
		case '7':
			$bulan = "Juli";
			break;
		case '8':
			$bulan = "Agustus";
			break;
		case '9':
			$bulan = "September";
			break;
		case '10':
			$bulan = "Oktober";
			break;
		case '11':
			$bulan = "November";
			break;
		case '12':
			$bulan = "Desember";
			break;
		default:
			$bulan = "";
			break;
	}

	return $bulan;
}

function tglIndonesia($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = namaBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}

function timeIndonesia($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = namaBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	$jam = substr($tgl,10,9);
	return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
}

?>