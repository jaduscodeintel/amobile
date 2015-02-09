<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

//print_r($_POST);
if ($_POST["id"])
{
	$qry = "INSERT INTO tech_dispatch (did, tid) VALUES ('".$_POST["id"]."','0')";
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}
