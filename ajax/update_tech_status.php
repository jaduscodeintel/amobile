<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "UPDATE techs SET status = '".$_POST["statusid"]."' WHERE id = ".$_POST["id"];

$etas = mysqli_query($connection, $qry) or die (mysqli_error()); 

echo "Success";


?>
