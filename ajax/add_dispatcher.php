<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "INSERT INTO users (level, password_change) VALUES (2,1)";

mysqli_query($connection, $qry) or die (mysqli_error());

$uid = mysqli_insert_id($connection);

$qry = "INSERT INTO dispatchers (uid) VALUES (".$uid.")";

mysqli_query($connection, $qry) or die (mysqli_error()); 

echo mysqli_insert_id($connection);


?>
