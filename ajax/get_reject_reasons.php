<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM rejected_reasons";

$rejects = mysqli_query($connection, $qry) or die (mysqli_error()); 
$reject = mysqli_fetch_array($rejects);

if ($reject)
{
	echo "<select name='reasons' id='reject_reasons_id'><option value='0'>Choose One...</option>";
		
		do 
		{
				echo "<option value='".$reject["id"]."'>".$reject["reason"]."</option>";
		
		} while ($reject = mysqli_fetch_array($rejects));
		
		echo "</select>";
}
?>
