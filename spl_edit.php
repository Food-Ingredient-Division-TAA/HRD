<?php
require_once("db_controller.php");
$db_handle = new DBController();
$sql = "UPDATE lemburan SET stts_spl = '".$_POST["kode"]."' WHERE  id_lembur=".$_POST["id"];
$result = $db_handle->executeUpdate($sql);
?>