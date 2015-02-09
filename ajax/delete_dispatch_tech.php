<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

print_r($_POST);
if ($_POST["id"])
{
	$qry = "DELETE FROM tech_dispatch WHERE id = ".$_POST["id"];
	echo $qry;
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}
