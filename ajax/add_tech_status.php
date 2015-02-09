<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "INSERT INTO tech_status (name) VALUES ('new')";
mysqli_query($connection, $qry) or die (mysqli_error()); 

echo mysqli_insert_id($connection);