<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM etas";

$etas = mysqli_query($connection, $qry) or die (mysqli_error()); 
$eta = mysqli_fetch_array($etas);

if ($eta)
{
	if ($dispatch)
	{
		echo "<select name='etas_select' id='eta_id' onchange='update_dispatch(\"eta_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($eta["id"] == $dispatch["eta_id"])
			{
				echo "<option value='".$eta["id"]."' selected='selected'>".$eta["eta"]."</option>";
			} else {
				echo "<option value='".$eta["id"]."'>".$eta["eta"]."</option>";
			}
		} while ($eta = mysqli_fetch_array($etas));
		
		echo "</select>";
	} else {
		echo "<select name='etas_select' id='eta_id' onchange='update_dispatch(\"eta_id\", this.value);'><option value='0'>Choose One...</option>";
	
		do {
			echo "<option value='".$eta["id"]."'>".$eta["eta"]."</option>";
		} while ($eta = mysqli_fetch_array($etas));
		
		echo "</select>";
	}
	
}
?>
