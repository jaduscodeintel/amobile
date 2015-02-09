<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM problems";

$problems = mysqli_query($connection, $qry) or die (mysqli_error()); 
$problem = mysqli_fetch_array($problems);

if ($problem)
{
	if ($dispatch)
	{
		echo "<select name='problem_description_select' id='problem_id' onchange='update_dispatch(\"problem_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($problem["id"] == $dispatch["problem_id"])
			{
				echo "<option value='".$problem["id"]."' selected='selected'>".$problem["problem"]."</option>";
			} else {
				echo "<option value='".$problem["id"]."'>".$problem["problem"]."</option>";
			}
		} while ($problem = mysqli_fetch_array($problems));
		
		echo "</select>";
	} else {
		echo "<select name='problem_description_select' id='problem_id' onchange='update_dispatch(\"problem_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			echo "<option value='".$problem["id"]."'>".$problem["problem"]."</option>";
		} while ($problem = mysqli_fetch_array($problems));
		
		echo "</select>";
	}
}
?>
