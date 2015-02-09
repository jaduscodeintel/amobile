<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT address, phone, fax, email, customer_communications, dispatch_notes FROM customers WHERE id = ".$_POST["id"];

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{
	echo $tech["address"]."|".$tech["phone"]."|".$tech["fax"]."|".$tech["email"]."|".$tech["customer_communications"]."|".$tech["dispatch_notes"];	
}
?>
