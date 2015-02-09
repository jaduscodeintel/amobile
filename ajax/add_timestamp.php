<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$timestamp = date("Y-m-d H:i:s", strtotime('-5 hours'));
$did = $_POST["id"];
$userid = $_POST["user"];
$cuserid = $_SESSION["loginid"];
$sid = $_POST["sid"];
$type = $_POST["atype"];

$qry = "INSERT INTO timestamp_tracker (did, userid, cuserid, sid, type, timestamp) VALUES ('".$did."','".
$userid."','".$cuserid."','".$sid."','".$type."','".$timestamp."')";

mysqli_query($connection, $qry) or die (mysqli_error());

$qry = "UPDATE dispatch SET tech_status_id = '".$sid."' WHERE id = '".$did."'";
mysqli_query($connection, $qry) or die (mysqli_error());


?>
