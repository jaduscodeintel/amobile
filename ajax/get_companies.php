<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM customers WHERE disabled = '0' ORDER BY name";

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{
	if ($dispatch)
	{
		echo "<select name='company_select' id='company_id' onchange='update_dispatch(\"company_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($tech["id"] == $dispatch["company_id"])
			{
				echo "<option value='".$tech["id"]."' selected='selected'>".$tech["name"]."</option>";
			} else {
				echo "<option value='".$tech["id"]."'>".$tech["name"]."</option>";
			}
		} while ($tech = mysqli_fetch_array($techs));
		
		echo "</select>";
	} else {
		echo "<select name='company_select' id='company_id' onchange='update_dispatch(\"company_id\", this.value);'><option value='0'>Choose One...</option>";
	
		do {
			echo "<option value='".$tech["id"]."'>".$tech["name"]."</option>";
		} while ($tech = mysqli_fetch_array($techs));
		
		echo "</select>";
	}
	
}
?>
