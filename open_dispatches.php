<script language="javascript">
function close_dispatch(did)
{
	$.ajax
	({
		type: "POST",
		url: "ajax/update_close_dispatch.php",
		data: {id : did},
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#open_dispatches").html(result);
				add_timestamp(did, 0, 'Close Dispatch', 0);
				tabs3_click();
				tabs4_click();
			}
		}
	});
}
</script>
<?php
$qry = "SELECT customers.name AS cname, dispatch.*, dispatchers.dispatcher, tech_status.name as tstatus, problems.problem, etas.eta_value FROM dispatch 
LEFT JOIN customers ON (customers.id = dispatch.company_id)
LEFT JOIN dispatchers ON (dispatchers.id = dispatch.dispatcher_id)
LEFT JOIN tech_status ON (dispatch.tech_status_id = tech_status.id)
LEFT JOIN problems ON (problems.id = dispatch.problem_id)
LEFT JOIN etas ON (etas.id = dispatch.eta_id)
WHERE open = '1' AND cancelled = 0 ORDER BY id DESC";
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

function calculateWarningTime($dispatchTime, $etaTime)
{
	$eta = strtotime( $dispatchTime ) + $etaTime * 3600;

	$now = time();
	
	$now = $now - 18000;
	
	if ($eta > $now)
	{
		$minutes = ($eta - $now)/60;
	} else {
		$minutes = ($eta - $now)/60;
	}
	
	if ($minutes < -15)
	{
		return "#F77722";
	} else if ($minutes < 15) {
		return "#FFFF37";
	} else {
		return "WHITE";
	}
}
?>

<div align="center" id="open_dispatches">
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;" valign="middle">
        	<div style="border:1px solid RED;" >
            <?php if ($dispatch) { ?>
            <table width="100%" align="center">
            	<tr bgcolor="#999999" style="font-weight:bold;">
                	<td>RO Number</td>
                    <td>Customer</td>
                    <td>City</td>
                    <td>Dispatcher</td>
                    <td>Tech</td>
                    <td>Tech Status</td>
                    <td>Time in Status</td>
                    <td>Problem</td>
                    <td>ETA Time</td>
                    <td>&nbsp;</td>
                </tr>
                <?php do { 
				
					$timeinstatus = "";
					$qry = "SELECT tech_status.name as sname, techs.name, tech_dispatch.sid, tech_dispatch.tid FROM techs LEFT JOIN tech_dispatch ON (tech_dispatch.tid = techs.id) LEFT JOIN dispatch ON (dispatch.id = tech_dispatch.did) LEFT JOIN tech_status ON (tech_status.id = tech_dispatch.sid) WHERE dispatch.id = ".$dispatch["id"]." ORDER BY tech_dispatch.id ASC";
					$techs = mysqli_query($connection, $qry); 

					$tech = mysqli_fetch_array($techs);
					
					if (!$tech["sname"])
					{
						$tech["sname"] = "Waiting...";
					}
					
					$elapseTime = calculateElapseTime($dispatch["date_time"]);	
					
					if ($tech["sid"] > 1)
					{
						$warningcolor = "#E4E4E4";	
					} else {
						$warningcolor = calculateWarningTime($dispatch["date_time"], $dispatch["eta_value"]);	
					}
					
					if ($tech["tid"])
					{
						$timeinstatus = getLastStatusChange($dispatch["id"], $tech["sid"], $tech["tid"]);
					} else {
						$timeinstatus = "NONE FOUND";
					}
				?>
                <tr bgcolor="<?php echo $warningcolor; ?>">
                	<td align="center"><a href="#" style="color:#00006F;" onclick="tabs2_click(<?php echo $dispatch["id"]; ?>);"><strong><?php echo $dispatch["RO"]; ?></strong></a></td>
                    <td><?php echo $dispatch["cname"]; ?></td>
                    <td><?php echo $dispatch["city_location"]; ?></td>
                    <td><?php echo $dispatch["dispatcher"]; ?></td>
                    <td><?php echo $tech["name"]; ?></td>
                    <td><?php echo $dispatch["tstatus"]; ?></td>
                    <td>
					<?php 
						//echo $elapseTime;
						//echo $warningcolor;
						echo $timeinstatus;
					?>
                    </td>
                    <td><?php echo $dispatch["problem"]; ?></td>
                    <td><?php echo date( "h:i:s A", strtotime( $dispatch["date_time"] ) + $dispatch["eta_value"] * 3600 ); ?></td>
                    <td align="center"><a href="#" style="color:#00006F;" onclick="close_dispatch(<?php echo $dispatch["id"]; ?>);"><strong>Close</strong></a></td>
				</tr>
                <?php } while ($dispatch = mysqli_fetch_array($dispatches)); ?>
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
                	<td colspan="9"><input type="button" onclick="javascript:tabs3_click();" value="Refresh"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
</body>
</html>
