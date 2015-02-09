<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM tire_storage_locations";

$locations = mysqli_query($connection, $qry) or die (mysqli_error()); 
$location = mysqli_fetch_array($locations);

if ($location)
{
	if ($dispatch)
	{
		echo "<select name='tire_storage_locations_select' id='tire_storage_id' onchange='update_dispatch(\"tire_storage_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($location["id"] == $dispatch["tire_storage_id"])
			{
				echo "<option value='".$location["id"]."' selected='selected'>".$location["tire_storage_location"]."</option>";
			} else {
				echo "<option value='".$location["id"]."'>".$location["tire_storage_location"]."</option>";
			}
		} while ($location = mysqli_fetch_array($locations));
		
		echo "</select>";
	} else {
		echo "<select name='tire_storage_locations_select' id='tire_storage_id' onchange='update_dispatch(\"tire_storage_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
		echo "<option value='".$location["id"]."'>".$location["tire_storage_location"]."</option>";
	} while ($location = mysqli_fetch_array($locations));
		
		echo "</select>";
	}

	
}
?>
