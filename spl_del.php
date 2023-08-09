<?php
include_once("koneksihr.php");
include_once("conn_hygiene.php");
if(isset($_POST['pwg_id'])) {
 $pwg_id = trim($_POST['pwg_id']);
 $sql = "DELETE FROM lemburan WHERE id_lembur in ($pwg_id)";
 $resultset = mysqli_query($konekhr, $sql) or die("database error:". mysqli_error($konekhr));
//  echo $pwg_id;
}
?>