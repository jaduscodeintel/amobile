<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

if ($_POST["id"])
{
	$qry = "UPDATE dispatch SET open = 1 WHERE id = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}

echo "Success";
?>