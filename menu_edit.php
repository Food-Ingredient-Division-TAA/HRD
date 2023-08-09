<?php
require_once("db_controller2.php");
$db_handle = new DBController();
$sql = "UPDATE menu_makan SET " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  id_menu=".$_POST["id"];
$result = $db_handle->executeUpdate($sql);
?>