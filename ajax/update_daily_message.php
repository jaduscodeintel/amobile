\<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "UPDATE daily_message SET message = '".$_POST["message"]."' WHERE id = 1";

$etas = mysqli_query($connection, $qry) or die (mysqli_error()); 

echo "Success";


?>
