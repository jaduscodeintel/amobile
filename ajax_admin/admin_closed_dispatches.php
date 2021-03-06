<?php
error_reporting(E_ALL & ~E_NOTICE);
if (!$require)
{
	require_once('../db/DB.php');
}

if ($_POST["id"])
{
	$qry = "UPDATE dispatch SET open = 0 WHERE id = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}

$qry = "SELECT users.name AS uname,timestamp_tracker.cuserid, timestamp_tracker.timestamp AS tstamp, timestamp_tracker.type as ttype, customers.name AS cname, dispatch.*, dispatchers.dispatcher, techs.name, tech_status.name as tstatus, problems.problem, etas.eta_value FROM dispatch 
LEFT JOIN timestamp_tracker ON (dispatch.id = timestamp_tracker.did)
LEFT JOIN users ON (users.id = timestamp_tracker.cuserid)
LEFT JOIN customers ON (dispatch.company_id = customers.id)
LEFT JOIN dispatchers ON (dispatch.dispatcher_id = dispatchers.id)
LEFT JOIN techs ON (dispatch.tech_id = techs.id)
LEFT JOIN tech_status ON (dispatch.tech_status_id = tech_status.id)
LEFT JOIN problems ON (dispatch.problem_id = problems.id)
LEFT JOIN etas ON (etas.id = dispatch.eta_id) WHERE dispatch.open = '0' AND timestamp_tracker.type = 'Close Dispatch'";



if ($_POST["searchfield"])
{
	$qry .= " AND ".$_POST["searchfield"]." LIKE '%".$_POST["searchval"]."%'";	?>
    <script language="javascript">
	$(document).ready(function() 
	{ 
		$("#archivetable").tablesorter(); 
	}); 
	</script>
    <?php
}

$qry .=" GROUP BY dispatch.id ORDER BY dispatch.id DESC";

$dispatches = mysqli_query($connection, $qry); 
$dispatch = mysqli_fetch_array($dispatches);

function calculateElapseTime($starttime)
{
	$today = date("Y-m-d H:i:s");
	$time = strtotime($today) - strtotime($starttime);
	
	$days = floor($time / (60 * 60 * 24));
	$time -= $days * (60 * 60 * 24);
	
	$hours = floor($time / (60 * 60));
	$time -= $hours * (60 * 60);
	
	$minutes = floor($time / 60);
	$time -= $minutes * 60;
	
	$seconds = floor($time);
	$time -= $seconds;
	
	return "{$days}d {$hours}h {$minutes}m {$seconds}s";	
}

function getLastStatusChange($id, $status, $techid)
{
	global $connection;
	
	$qry = "SELECT timestamp FROM timestamp_tracker WHERE did = ".$id." AND userid = ".$techid." ORDER BY id DESC";
	$tstamps = mysqli_query($connection, $qry) or die("Query Failed: " . mysqli_error());
	$tstamp = mysqli_fetch_array($tstamps);
	
	if ($tstamp["timestamp"])
	{
		$rtime = calculateElapseTime($tstamp["timestamp"]);
		return $rtime;	
	} else {
		return "NONE FOUND";
	}
}

?>
<div align="center">
<div id="searchform">
<strong>Search:</strong>&nbsp;&nbsp;&nbsp;&nbsp;
<select name="searchdrop" id="searchdrop">
	<option value="RO">RO</option>
    <option value="customers.name">Customer</option>
    <option value="dispatchers.dispatcher">Dispatcher</option>
    <option value="dispatch.customer_ref_num">Customer Ref Num</option>
    <option value="users.name">Close By</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30" id="searchfield" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Search" onclick="javascript:search_archives();" />
<p><hr /></p>
</div>
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;" valign="middle">
        	<div style="border:1px solid RED;" >
            <?php if ($dispatch) { ?>
            <table width="100%" align="center" class="tablesorter" id="archivetable">
              <thead>
            	<tr>
                	<th>RO Number</th>
                    <th>Customer</th>
                    <th>Customer Ref#</th>
                    <th>Dispatcher</th>
                    <th>Tech</th>
                    <th>Closed Time</th>
                    <th>Type</th>
                    <th>Closed By</th>
                    <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php do { 
					$elapseTime = calculateElapseTime($dispatch["date_time"]);	
					$timeinstatus = getLastStatusChange($dispatch["id"], $dispatch["tech_status_id"], $dispatch["tech_id"]);
					
					$qry = "SELECT tech_status.name as sname, techs.name, tech_dispatch.sid, tech_dispatch.tid FROM techs LEFT JOIN tech_dispatch ON (tech_dispatch.tid = techs.id) LEFT JOIN dispatch ON (dispatch.id = tech_dispatch.did) LEFT JOIN tech_status ON (tech_status.id = tech_dispatch.sid) WHERE dispatch.id = ".$dispatch["id"]." ORDER BY tech_dispatch.id ASC";
					$techs = mysqli_query($connection, $qry); 

					$tech = mysqli_fetch_array($techs);
					
					
					if ($warningcolor == "WHITE")
					{
						$warningcolor = "#FBFBFB";
					} else {
						$warningcolor = "WHITE";
					}
				?>
              
                <tr bgcolor="<?php echo $warningcolor; ?>">
                	<td><a href="#" style="color:#00006F;" onclick="tabs2_click(<?php echo $dispatch["id"]; ?>);"><strong><?php echo $dispatch["RO"]; ?></strong></a></td>
                    <td><?php echo $dispatch["cname"]; ?></td>
                    <td><?php echo $dispatch["customer_ref_num"]; ?></td>
                    <td><?php echo $dispatch["dispatcher"]; ?></td>
                    <td><?php echo $tech["name"]; ?></td>
                    <td><?php echo $dispatch["tstamp"]; ?></td>
                    <td><?php echo $dispatch["ttype"]; ?></td>
                    <td><?php echo $dispatch["uname"]; ?></td>
                    <td><a href="#" style="color:#00006F;" onclick="reopen_dispatch(<?php echo $dispatch["id"]; ?>);"><strong>re-open</strong></a></td>
				</tr>
                <?php } while ($dispatch = mysqli_fetch_array($dispatches)); ?>
              </tbody>
            </table>
            <?php } else { ?>
            	<h2 align="center">NO OPEN DISPATCHES</h2>
            <?php } ?>
            </div>
             <table width="1200" border="0" cellpadding="0" cellspacing="0" align="center">
             	<tr>
                	<td colspan="9">&nbsp;</td>
                </tr>
             	<tr>
                	<td colspan="9"><input type="button" onclick="javascript:tabs1_click();" value="Refresh"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
