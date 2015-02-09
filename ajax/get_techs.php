<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

if ($dispatch["id"])
{
	$_POST["id"] = $dispatch["id"];	
}

$qry = "SELECT * FROM tech_dispatch WHERE did = '".$_POST["id"]."' ORDER BY id ASC";
$dtechs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$dtech = mysqli_fetch_array($dtechs);

if ($dtech)
{
	do {
		$qry = "SELECT techs.*, tech_status.name AS tname FROM techs LEFT JOIN tech_status ON (tech_status.id = techs.status) WHERE techs.disabled = '0'";
		
		$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
		$tech = mysqli_fetch_array($techs);
		
		if ($tech)
		{
	
			echo "<select name='techs_select' id='tech_id' onchange='update_tech(".$_POST["id"].",".$dtech["id"].", this.value);'>";
			if ($dtech["tid"])
			{
				echo "<option value='0'>Choose One...</option>";
			} else {
				echo "<option value='0' selected='selected'>Choose One...</option>";
			}
			
			do {
				if ($tech["id"] == $dtech["tid"])
				{
					echo "<option value='".$tech["id"]."' selected='selected'>".$tech["name"]." (".$tech["tname"].")</option>";
				} else {
					echo "<option value='".$tech["id"]."'>".$tech["name"]." (".$tech["tname"].")</option>";
				}
			} while ($tech = mysqli_fetch_array($techs));
			
			echo "</select>&nbsp;&nbsp;";
			echo '<a href="#" onclick="javascript:if(confirm(\'Are you sure?\')){delete_tech('.$dtech["id"].')};" style="font-size:9px;">delete tech</a>';
			echo "<br>";
			
			
		}
	} while ($dtech = mysqli_fetch_array($dtechs));
}
?>
<a href="#" onclick="add_tech(<?php echo $_POST["id"]; ?>);" style="font-size:9px;">add tech</a>
