<?php
include_once("koneksi.php");
if(isset($_POST['pwg_id'])) {
 $pwg_id = substr(trim($_POST['pwg_id']),0,-1);
 $sql = "DELETE FROM menu_makan WHERE id_menu in ($pwg_id)";
 $resultset = mysqli_query($konek, $sql) or die("database error:". mysqli_error($konek));
 echo $pwg_id;
}
?>