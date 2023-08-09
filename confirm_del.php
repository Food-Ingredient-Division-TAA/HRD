<?php
include_once("koneksi.php");
if(isset($_POST['pwg_id'])) {
 $pwg_id = trim($_POST['pwg_id']);
 $sql = "DELETE FROM order_makan WHERE id_order in ($pwg_id)";
 $resultset = mysqli_query($konek, $sql) or die("database error:". mysqli_error($konek));
 echo $pwg_id;
}
?>