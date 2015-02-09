<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM tire_sizes";

$sizes = mysqli_query($connection, $qry) or die (mysqli_error()); 
$size = mysqli_fetch_array($sizes);

if ($size)
{
	if ($dispatch)
	{
		echo "<select name='tire_sizes_select' id='tire_size_id' onchange='update_dispatch(\"tire_size_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($size["id"] == $dispatch["tire_size_id"])
			{
				echo "<option value='".$size["id"]."' selected='selected'>".$size["tire_size"]."</option>";
			} else {
				echo "<option value='".$size["id"]."'>".$size["tire_size"]."</option>";
			}
		} while ($size = mysqli_fetch_array($sizes));
		
		echo "</select>";
	} else {
		echo "<select name='tire_sizes_select' id='tire_size_id' onchange='update_dispatch(\"tire_size_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			echo "<option value='".$size["id"]."'>".$size["tire_size"]."</option>";
		} while ($size = mysqli_fetch_array($sizes));
		
	echo "</select>";
	}
	

}
?>
