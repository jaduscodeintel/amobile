<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');



$qry = "SELECT dispatch.RO, dispatch.address_location, dispatch.city_location, dispatch.zip_location, dispatch.county_location, states.name as state, customers.name as cname FROM dispatch LEFT JOIN states ON (states.id = dispatch.state_id) LEFT JOIN customers ON (customers.id = dispatch.company_id) WHERE dispatch.id = ".$_POST["did"];

$locations = mysqli_query($connection, $qry) or die (mysqli_error()); 
$location = mysqli_fetch_array($locations);

$qry = "SELECT name, email FROM techs WHERE id = ".$_POST["tid"];
$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech["email"])
{
 //change this to your email. 
	$to = $tech["email"];
	$from = "amobil1823@amobilemaintenance.net";
    $subject = "New Dispatch Assigned To You"; 

    //begin of HTML message 
    $message = "\r\n\r\nRO - ".$location["RO"]."\r\nLink to info - http://www.amobilemaintenance.net/mobileapp/main.php\r\nPut your status to 'In Route' once you leave for call\r\n\r\n";
   //end of message 
    $headers  = "From: $from\r\n"; 
    $headers .= "Content-type: text/html\r\n"; 
    // now lets send the email. 
    mail($to, $subject, $message, $headers); 
	



    echo "Message has been sent....! Sent to: ".$tech["email"];
} else {
	echo "MESSAGE WAS NOT SENT. No number available, please contact Tech Directly";	
}