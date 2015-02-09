<script language="javascript">
function update_tech_status(tid, sid)
{
	$.ajax
	({
		type: "POST",
		url: "ajax/update_tech_status.php",
		data: {id : tid, statusid : sid},
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$(".status_updates").html("");
				$("#status_update_" + tid).html("<font color='green' style='font-size:14px;'>Tech Status Successfully Updated</font>");
			}
		}
	});
}
</script>

<?php
$qry = "SELECT techs.*, tech_status.id as tid FROM techs LEFT JOIN tech_status ON (techs.status = tech_status.id) WHERE techs.disabled = 0";

if ($_SESSION["userlevel"] == 1)
{
	$qry .= " AND techs.id = ".$_SESSION["tid"];
}

$qry .= " ORDER BY name";

$techs = mysqli_query($connection, $qry); 
$tech = mysqli_fetch_array($techs);

$qry = "SELECT * FROM tech_status WHERE id > 5 ORDER BY id";
$statuses2 = mysqli_query($connection, $qry); 
$status2 = mysqli_fetch_array($statuses2);

global $id2, $name2, $x2;

do {
	$id2[] = $status2["id"];
	$name2[] = $status2["name"];
	$x2++;
} while ($status2 = mysqli_fetch_array($statuses2));

function get_status($tid)
{
	global $x2, $name2, $id2;
	
	for ($n=0; $n<$x2; $n++)
	{
		if ($n+6 == $tid)
		{
			echo '<option value="'.$id2[$n].'" selected="selected">'.$name2[$n].'</option>';	
		} else {
			echo '<option value="'.$id2[$n].'">'.$name2[$n].'</option>';	
		}
	}
}


?>
<div align="center">
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;" valign="middle">
        	<div style="border:1px solid RED;" >
            <?php if ($tech) { ?>
            <table width="98%" align="center">
            	<tr bgcolor="#999999" style="font-weight:bold;">
	               	<td width="20%">Tech Name</td>
                    <td>Tech Status</td>
                    <td>&nbsp;</td>
                </tr>
                <?php 
				$bgcolor="WHITE";
				do {	
				?>
                <tr bgcolor="<?php echo $bgcolor; ?>">
                	<td><?php echo $tech["name"]; ?></td>
                    <td><select name="status" onchange="update_tech_status(<?php echo $tech["id"]; ?>, this.value)">		
                    <?php get_status($tech["tid"]); ?>
                    </select>
                    </td>
                    <td class="status_updates" id="status_update_<?php echo $tech["id"]; ?>"></td>
				</tr>
                <?php 
					if ($bgcolor == "WHITE")
					{
						$bgcolor = "#F2F2F2";
					} else {
						$bgcolor="WHITE";
					}
				} while ($tech = mysqli_fetch_array($techs)); ?>
            </table>
            <?php } else { ?>
            	<h2 align="center">NO TECHS!</h2>
            <?php } ?>
            </div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
