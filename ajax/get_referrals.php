<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT * FROM referral_type";

$referrals = mysqli_query($connection, $qry) or die (mysqli_error()); 
$referral = mysqli_fetch_array($referrals);

if ($referral)
{
	if ($dispatch)
	{
		echo "<select name='hear_about_us_select' id='how_did_you_hear_id' onchange='update_dispatch(\"how_did_you_hear_id\", this.value);'><option value='0'>Choose One...</option>";
		
		do {
			if ($referral["id"] == $dispatch["how_did_you_hear_id"])
			{
				echo "<option value='".$referral["id"]."' selected='selected'>".$referral["referral"]."</option>";
			} else {
				echo "<option value='".$referral["id"]."'>".$referral["referral"]."</option>";
			}
		} while ($referral = mysqli_fetch_array($referrals));
		
		echo "</select>";
	} else {
		echo "<select name='hear_about_us_select' id='how_did_you_hear_id' onchange='update_dispatch(\"how_did_you_hear_id\", this.value);'><option value='0'>Choose One...</option>";
	
		do {
			echo "<option value='".$referral["id"]."'>".$referral["referral"]."</option>";
		} while ($referral = mysqli_fetch_array($referrals));
		
		echo "</select>";
	}
	
}
?>
