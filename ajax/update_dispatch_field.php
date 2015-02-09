<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$textToStore = nl2br(htmlentities($_POST["value"], ENT_QUOTES, 'UTF-8'));

$qry = "UPDATE dispatch SET ".$_POST["fieldname"]." = '".$textToStore."' WHERE id = ".$_POST["id"];

$etas = mysqli_query($connection, $qry) or die (mysqli_error()); 

echo "Success";


?>
