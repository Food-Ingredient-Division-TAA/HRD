<?php
$server = "10.124.24.100";
$base = array("Database" => "idmp_palembang", "UID"=>"sa", "PWD"=>"Samba07@");
$conndigi = sqlsrv_connect($server, $base);
if(!$conndigi){
    echo "Connection is running out";
    die(print_r(sqlsrv_errors(), true));
}
?>