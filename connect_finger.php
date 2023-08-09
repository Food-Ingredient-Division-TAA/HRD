<?php
$server = "10.126.24.151";
$base = array("Database" => "HITFPTA1", "UID"=>"sa", "PWD"=>"indofood");
$connfinger = sqlsrv_connect($server, $base);
if(!$connfinger){
    echo "Connection is running out";
    die(print_r(sqlsrv_errors(), true));
}
?>