<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

if ($_POST["id"])
{
	$qry = "DELETE FROM images_dispatch WHERE id = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
	
	unlink("../uploads/uploads/".$_POST["largephoto"]);
	unlink("../uploads/uploads/".$_POST["smallphoto"]);
	
	$did = $_POST["did"];
	
	$qry = "SELECT * FROM images_dispatch WHERE did = ".$did." ORDER BY id";
	$images = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$image = mysqli_fetch_array($images);
	
	echo '<div align="center"><hr><br>';
	
	if ($image)
	{
		do {
			echo '<a class="fancyboxphotos" href="uploads/uploads/'.$image["original_image"].'"><img src="uploads/uploads/'.$image["thumbnail_image"].'" alt="Thumbnail"></a>&nbsp;<a href="#" onclick="delete_photo('.$image["id"].',\''.$image["original_image"].'\',\''.$image["thumbnail_image"].'\');"><img src="uploads/images/delete.png" width="10px" height="auto"></a>&nbsp;';
		} while ($image = mysqli_fetch_array($images));
	} else {
		echo "<h2>NO IMAGES UPLOADED</h2>";
	}
	
	echo '<br><hr></div>';
	
}
