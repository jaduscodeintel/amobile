<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

if ($_POST["fieldname"] == "dispatcher")
{
	$qry = "SELECT uid FROM dispatchers WHERE id = ".$_POST["id"];
	$dispatchers = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$dispatcher = mysqli_fetch_array($dispatchers);
	
	if ($dispatcher["uid"])
	{
		$qry = "SELECT username FROM users WHERE id = ".$dispatcher["uid"];
		$users = mysqli_query($connection, $qry) or die (mysqli_error()); 
		$user = mysqli_fetch_array($users);
		
		if ($user["username"] == "")
		{
			$password = md5($_POST["value"]."2014");
			$qry = "UPDATE users SET username = '".$_POST["value"]."', password = '".$password."', name = '".ucfirst($_POST["value"])."' WHERE id = ".$dispatcher["uid"];
			mysqli_query($connection, $qry) or die (mysqli_error()); 
		} 
	}
}

if ($_POST["fieldname"] == "disabled")
{	
	$qry = "SELECT uid FROM dispatchers WHERE id = ".$_POST["id"];
	$dispatchers = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$dispatcher = mysqli_fetch_array($dispatchers);

	$qry = "UPDATE users SET disabled = '".$_POST["value"]."' WHERE id = ".$dispatcher["uid"];
	mysqli_query($connection, $qry) or die (mysqli_error());
}

if ($_POST["fieldname"] == "password")
{
	$password = md5($_POST["value"]);
	
	$qry = "SELECT uid FROM dispatchers WHERE id = ".$_POST["id"];
	$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$tech = mysqli_fetch_array($techs);

	$qry = "UPDATE users SET password = '".$password."' WHERE id = ".$tech["uid"];
	mysqli_query($connection, $qry) or die (mysqli_error());
	
	echo "Success";
	
	
} else {
	$qry = "UPDATE dispatchers SET ".$_POST["fieldname"]." = '".$_POST["value"]."' WHERE id = ".$_POST["id"];
	
	$etas = mysqli_query($connection, $qry) or die (mysqli_error()); 
	
	echo "Success";
}


?>
