<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM dispatchers WHERE disabled = '0'";

$dispatchers2 = mysqli_query($connection, $qry) or die (mysqli_error()); 
$dispatcher = mysqli_fetch_array($dispatchers2);

if ($dispatcher)
{
	if ($dispatch)
	{
			echo "<select name='dispatchers_select' id='dispatcher_id' onchange='update_dispatch(\"dispatcher_id\", this.value);'";
			
			if ($_SESSION["userlevel"] < 3) 
			{ 
				echo "disabled";
			}
			
			echo "><option value='0'>Choose One...</option>";
			$selected = 0;
		do {
			
			if ($selected)
			{
				echo "<option value='".$dispatcher["id"]."'>".$dispatcher["dispatcher"]."</option>";
			} else if ($dispatcher["id"] == $dispatch["dispatcher_id"]){
				echo "<option value='".$dispatcher["id"]."' selected='selected'>".$dispatcher["dispatcher"]."</option>";
				$selected = 1;
			} else if ($dispatcher["id"] == $_SESSION["did"]) { 
				echo "<option value='".$dispatcher["id"]."' selected='selected'>".$dispatcher["dispatcher"]."</option>";
				$selected = 1;
		    } else {
				echo "<option value='".$dispatcher["id"]."'>".$dispatcher["dispatcher"]."</option>";
			}
		} while ($dispatcher = mysqli_fetch_array($dispatchers2));
		
		echo "</select>";
	} else {
		echo "<select name='dispatchers_select' id='dispatcher_id' onchange='update_dispatch(\"dispatcher_id\", this.value);'><option value='0'>Choose One...</option>";
		$selected = 0;
		do {
			if ($selected)
			{
				echo "<option value='".$dispatcher["id"]."'>".$dispatcher["dispatcher"]."</option>";
			} else if ($dispatcher["id"] == $_SESSION["did"])
			{
				echo "<option value='".$dispatcher["id"]."' selected='selected'>".$dispatcher["dispatcher"]."</option>";
				$selected = 1;
			} else {
				echo "<option value='".$dispatcher["id"]."'>".$dispatcher["dispatcher"]."</option>";
			}
		} while ($dispatcher = mysqli_fetch_array($dispatchers2));
		
		echo "</select>";
	}
	
}
?>
