<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM tire_codes";

$codes = mysqli_query($connection, $qry) or die (mysqli_error()); 
$code = mysqli_fetch_array($codes);

if ($code)
{
	if ($dispatch)
	{
		echo "<select name='tire_codes_select' id='tire_code_id' onchange='update_dispatch(\"tire_code_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($code["id"] == $dispatch["tire_code_id"])
			{
				echo "<option value='".$code["id"]."' selected='selected'>".$code["tire_code"]."</option>";
			} else {
				echo "<option value='".$code["id"]."'>".$code["tire_code"]."</option>";
			}
		} while ($code = mysqli_fetch_array($codes));
		
		echo "</select>";
	} else {
		echo "<select name='tire_codes_select' id='tire_code_id' onchange='update_dispatch(\"tire_code_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			echo "<option value='".$code["id"]."'>".$code["tire_code"]."</option>";
		} while ($code = mysqli_fetch_array($codes));
		
		echo "</select>";
	}
		
}
?>
