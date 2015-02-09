<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT dispatch_notes FROM customers WHERE id = ".$_POST["id"];

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{
	echo $tech["dispatch_notes"];	
}
?>
