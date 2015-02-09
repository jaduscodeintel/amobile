<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM states";

$states = mysqli_query($connection, $qry) or die (mysqli_error()); 
$state = mysqli_fetch_array($states);

if ($state)
{
	if ($dispatch)
	{
		echo "<select name='location_state_select' id='state_id' onchange='update_dispatch(\"state_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($state["id"] == $dispatch["state_id"])
			{
				echo "<option value='".$state["id"]."' selected='selected'>".$state["name"]."</option>";
			} else {
				echo "<option value='".$state["id"]."'>".$state["name"]."</option>";
			}
		} while ($state = mysqli_fetch_array($states));
		
		echo "</select>";
	} else {
		echo "<select name='location_state_select' id='state_id' onchange='update_dispatch(\"state_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			echo "<option value='".$state["id"]."'>".$state["name"]."</option>";
		} while ($state = mysqli_fetch_array($states));
		
		echo "</select>";
	}
	
}
?>
