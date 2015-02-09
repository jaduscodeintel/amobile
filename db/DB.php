<?php

session_start();

$hostname_DB = "localhost";
$database_DB = "amobile";
$username_DB = "amobil";
$password_DB = "fxbgg+ry";

$connection = mysqli_connect($hostname_DB,$username_DB,$password_DB);
if (!$connection) {
    die("Database connection failed: " . mysqli_error());
}

// 2. Select a database to use 
$db_select = mysqli_select_db($connection, $database_DB);
if (!$db_select) {
    die("Database selection failed: " . mysqli_error());
}

?>