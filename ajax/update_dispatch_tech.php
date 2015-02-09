<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

//print_r($_POST);
if ($_POST["id"])
{
	$qry = "UPDATE tech_dispatch SET tid = '".$_POST["tid"]."' WHERE id = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}
