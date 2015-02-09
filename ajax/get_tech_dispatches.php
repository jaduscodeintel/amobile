<?php

error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT tech_dispatch.id as tdid, tech_dispatch.sid, tech_dispatch.tid, techs.name as tname, states.name AS sname, customers.name AS cname, dispatch.*, tire_sizes.tire_size, problems.problem FROM tech_dispatch
LEFT JOIN dispatch ON (dispatch.id = tech_dispatch.did)
LEFT JOIN techs ON (techs.id = tech_dispatch.tid)
LEFT JOIN states ON (states.id = dispatch.state_id)
LEFT JOIN problems ON (problems.id = dispatch.problem_id) 
LEFT JOIN tire_sizes ON (tire_sizes.id = dispatch.tire_size_id) 
LEFT JOIN customers ON (customers.id = dispatch.company_id)
WHERE dispatch.open = '1'";

if ($_SESSION["userlevel"] == 1)
{
 	$qry .= " AND tech_dispatch.tid = ".$_SESSION["tid"];	
}

$qry.= " ORDER BY id DESC";

$dispatches = mysqli_query($connection, $qry); 
$dispatch = mysqli_fetch_array($dispatches);

$qry = "SELECT * FROM tech_status WHERE id < 6 ORDER BY id";
$statuses = mysqli_query($connection, $qry); 
$status = mysqli_fetch_array($statuses);

global $id, $name, $x;

do {
	$id[] = $status["id"];
	$name[] = $status["name"];
	$x++;
} while ($status = mysqli_fetch_array($statuses));

function get_status_dispatch($tid)
{
	global $x, $name, $id;
	
	for ($n=0; $n<$x; $n++)
	{
		if ($n+1 == $tid)
		{
			echo '<option value="'.$id[$n].'" selected="selected">'.$name[$n].'</option>';	
		} else {
			echo '<option value="'.$id[$n].'">'.$name[$n].'</option>';	
		}
	}
}
?>
	<script type="text/javascript">
        var GB_ROOT_DIR = "../scripts/";
    </script>
    
    
    <script type="text/javascript" src="../scripts/AJS.js"></script>
    <script type="text/javascript" src="../scripts/AJS_fx.js"></script>
    <script type="text/javascript" src="../scripts/gb_scripts.js"></script>
    <link href="../scripts/gb_styles.css" rel="stylesheet" type="text/css" />
    
<div align="center" id="tech_dispatches">
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;" valign="middle">
        	<div style="border:1px solid RED;" >
            <?php if ($dispatch) { ?>
            <table width="98%" align="center">
            	<tr bgcolor="#999999" style="font-weight:bold;">
	               	<td>Tech/Status</td>
                    <td>RO Number</td>
                    <td>Company Name</td>
                    <td>Problem Description</td>
                    <td>Address</td>
                    <td>Special Instructions and Details</td>
                </tr>
                <?php do { ?>
                <tr>
               		<td>
						<table width="100%">
                        	<tr>
                            	<td align="left"><?php echo $dispatch["tname"]; ?></td>
                           		<td align="right"><select name="status" onchange="update_dispatch_tech_id('<?php echo $dispatch["id"]; ?>','<?php echo $dispatch["tid"]; ?>','<?php echo $dispatch["tdid"]; ?>', this.value)" <?php if ($_SESSION["userlevel"] == 3)
{ ?>
	class="admin"
<?php } else if ($dispatch["tid"] != $_SESSION["tid"]) {?>
	disabled<?php } ?>><option value="0">Waiting...</option>
                    <?php get_status_dispatch($dispatch["sid"]);?>
                    </select></td>
                    		</tr>
                      	</table>
                    </td>
                	<td><a href="#" onclick="tabs2_click(<?php echo $dispatch["id"]; ?>);"><?php echo $dispatch["RO"]; ?></a></td>
                    <td><?php echo $dispatch["cname"]; ?></td>
                    <td><?php echo $dispatch["problem"]; ?></td>
                    <td><?php 
					if ($dispatch["address_location"]) 
					{
						echo $dispatch["address_location"];
						echo ", ".$dispatch["city_location"];
						if ($dispatch["sname"])
						{
							echo ", ".$dispatch["sname"]." ".$dispatch["zip_location"].", ".$dispatch["county_location"]; 
						}
					}
						?>
                      </td>
                    <td><a class="fancyboxdetails" href="details.php?id=<?php echo $dispatch["id"]; ?>">Details</a></td>
				</tr>
                <?php } while ($dispatch = mysqli_fetch_array($dispatches)); ?>
            </table>
            <?php } else { ?>
            	<h2 align="center">NO TECH DISPATCHES</h2>
            <?php } ?>
            </div>
            <table width="1200" border="0" cellpadding="0" cellspacing="0" align="center">
             	<tr>
                	<td colspan="9">&nbsp;</td>
                </tr>
             	<tr>
                	<td colspan="9"><input type="button" onclick="javascript:tabs4_click();" value="Refresh"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
