<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "INSERT INTO tire_codes (tire_code) VALUES ('new')";
mysqli_query($connection, $qry) or die (mysqli_error()); 

echo mysqli_insert_id($connection);