<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM dispatch WHERE cancelled = 1 LIMIT 1";

$ros = mysqli_query($connection, $qry) or die (mysqli_error()); 
$ro = mysqli_fetch_array($ros);

if ($ro)
{
	$date = date("ym", strtotime('-5 hours'));
	
	if (strlen($ro["id"]) == 1)
	{
		$ro["id"] = "000".$ro["id"];	
	}
	
	if (strlen($ro["id"]) == 2)
	{
		$ro["id"] = "00".$ro["id"];	
	}
	
	if (strlen($ro["id"]) == 3)
	{
		$ro["id"] = "0".$ro["id"];	
	}
	
	$newro = $date."-".$ro["id"];
	$new_time = date("Y-m-d H:i:s", strtotime('-5 hours'));
	$currentdate = date('l F jS Y h:i:s A', strtotime('-5 hours'));
	$qry = "UPDATE dispatch SET cancelled = 0, RO = '".$newro."', date_time = '".$new_time."' WHERE id = ".$ro["id"];
	mysqli_query($connection, $qry);
	
	$qry = "INSERT INTO tech_dispatch (did, tid) VALUES ('".$ro["id"]."', '0')";
	mysqli_query($connection, $qry) or die (mysqli_error());
	
	echo $ro["id"].",".$newro."&nbsp;&nbsp;<span style='font-size:12px; color:black; font-weight:bold;'>" .$currentdate."</span>";
} else {
	$today = date("Y-m-d H:i:s", strtotime('-5 hours')); 
	$qry = "INSERT INTO dispatch (date_time, eta_id) VALUES ('".$today."', 1)";
	mysqli_query($connection, $qry) or die (mysqli_error());
	$id = mysqli_insert_id($connection);
	
	if (strlen($id) == 1)
	{
		$id = "000".$id;	
	}
	
	if (strlen($id) == 2)
	{
		$id = "00".$id;	
	}
	
	if (strlen($id) == 3)
	{
		$id = "0".$id;	
	}
	
	$returndate = date("ym", strtotime('-5 hours'));
	$ro = $returndate."-".$id;
	
	$qry = "UPDATE dispatch SET RO = '".$ro."' WHERE id = ".$id;
	mysqli_query($connection, $qry) or die (mysqli_error());

	$ro = "&nbsp;&nbsp;".$ro;
	$currentdate = date('l F jS Y h:i:s A', strtotime('-5 hours'));
	echo $id.",".$ro."&nbsp;&nbsp;<span style='font-size:12px; color:black; font-weight:bold;'>" .$currentdate."</span>";
	
	$qry = "INSERT INTO tech_dispatch (did, tid) VALUES ('".$id."', '0')";
	mysqli_query($connection, $qry) or die (mysqli_error());
}
?>
