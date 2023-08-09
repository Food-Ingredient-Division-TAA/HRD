<?php
include_once("koneksi.php");
include_once("conn_hygiene.php");
if(isset($_POST['pwg_id'])) {
 $pwg_id = trim($_POST['pwg_id']);
 $sql = "DELETE FROM area WHERE id_area in ($pwg_id)";
 $resultset = mysqli_query($hygiene_conn, $sql) or die("database error:". mysqli_error($hygiene_conn));
 echo $pwg_id;
}
?>