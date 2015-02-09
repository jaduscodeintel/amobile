<?php

if ($_POST["tech_refresh"])
{
	require_once('../db/DB.php');
}

$qry = "SELECT * FROM etas ORDER BY disabled, id";

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{?>
<script language="javascript">
function edit_eta(tid, stat)
{
	name = $("#eta_name_" + tid).html();
	etaval = $("#eta_val_" + tid).html();
	
	html = '<td><input type="text" onchange="update_eta_val('+tid+',\'eta\',this.value);" value="'+name+'" id="eta_name_' + tid + '"></td>';
	html = html + '<td><input type="text" onchange="update_eta_val('+tid+',\'eta_value\',this.value);" value="'+etaval+'" id="eta_val_' + tid + '"></td>';
	html = html + '<td align="center"><a href="javascript:unedit_eta(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#eta_" + tid).html(html);
	
}

function unedit_eta(tid,stat)
{

	if ($("#eta_name_" + tid).val())
	{
		name = $("#eta_name_" + tid).val();
	} else {
		name = $("#eta_name_" + tid).html();
	}

	if ($("#eta_val_" + tid).val())
	{
		etaval = $("#eta_val_" + tid).val();
	} else {
		etaval = $("#eta_val_" + tid).html();
	}

	
	html = '<td id="eta_name_' + tid + '">'+name+'</td>';
	html = html + '<td id="eta_val_' + tid + '">'+etaval+'</td>';
	
	if (stat == 1)
	{
		html = html + '<td align="center"><a href="javascript:edit_eta('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_eta_'+tid+'"><a href="javascript:enable_disable_eta('+tid+',0);">enable</a></span></td>';
	} else {
		html = html + '<td align="center"><a href="javascript:edit_eta('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_eta_'+tid+'"><a href="javascript:enable_disable_eta('+tid+',1);">disable</a></span></td>';
	}
	
	$("#eta_" + tid).html(html);
	
}

function enable_disable_eta(tid,val)
{
	update_eta_val(tid,'disabled',val);
	
	if (val == 1)
	{
		html = '<a href="javascript:enable_disable_eta('+tid+',0);">enable</a>';
		$("#edit_eta_"+tid).html(html);
		$("#eta_"+tid).css("background-color", "#FF6F6F");
	} else {
		html = '<a href="javascript:enable_disable_eta('+tid+',1);">disable</a>';
		$("#edit_eta_"+tid).html(html);
		$("#eta_"+tid).css("background-color", "WHITE");
	}
	
	finish_new_eta_status();
}

function update_eta_val(tid, field, val)
{

 	

		$.ajax
		({
			type: "POST",
			url: "ajax/update_eta_field.php",
			data: {id : tid, fieldname : field, value : val},
			success: function(result)
			{
				if (result) 
				{ 
					if (result == "Success")
					{
						html =  "<font color='blue'>Field " + field + " Successfully Updated</font>";
						//alert(html);
						//$("#update_msg").html(html);
					} else {
						html = "<font color='red'>Error Updating Field/font>";
						//alert(html);
						//$("#update_msg").html(html);
					}
				}
			}
		});

}

function add_new_eta()
{

		$.ajax
		({
			type: "POST",
			url: "ajax/add_etas.php",
			success: function(result)
			{
				if (result) 
				{ 
					tid = result;
					
					html = '<table><tr>';
					html = html + '<td><strong>ETA</strong></td>';
					html = html + '<td><strong>ETA Value</strong></td>';
					html = html + '</tr><tr>';
				 	html = html + '<td><input type="text" onchange="update_eta_val('+tid+',\'eta\',this.value);" id="eta_name_' + tid + '"></td>';
					html = html + '<td><input type="text" onchange="update_eta_val('+tid+',\'eta_value\',this.value);" id="eta_val_' + tid + '"></td>';
					html = html + '<td align="center"><a href="javascript:finish_new_eta_status();">FINISHED</a></td>';
					html = html + "</tr></table>";
					$("#add_new_eta_field").html(html);
				}
			}
		});

}

function finish_new_eta_status()
{
	
	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_etas.php",
			data: {tech_refresh : 1},
			success: function(result)
			{
				if (result) 
				{ 
					$("#tabs-5").html(result);
				}
			}
		});
}


</script>
<table width="98%">
    <tr>
        <td width="50%">
            <table width="100%">
                <tr bgcolor="#858585">
                    <td>Etas</td>
                    <td>Eta Value</td>
                    <td>&nbsp;</td>
                </tr>
                <?php 
				$bgcolor = "#E0E0E0";
				do { 
					if ($bgcolor == "WHITE")
					{
						$bgcolor = "#E0E0E0";
					} else {
						$bgcolor = "WHITE";
					}
				?>
                <tr id = "eta_<?php echo $tech["id"]; ?>" <?php if ($tech["disabled"]) {?> bgcolor="#FF6F6F" <?php } else { ?>bgcolor="<?php echo $bgcolor; ?>" <?php } ?>>
                    <td id="eta_name_<?php echo $tech["id"]; ?>"><?php echo $tech["eta"]; ?></td>
                    <td id="eta_val_<?php echo $tech["id"]; ?>"><?php echo $tech["eta_value"]; ?></td>
                    <?php if ($tech["disabled"]) { ?>
                     <td align="center"><a href="javascript:edit_eta(<?php echo $tech["id"]; ?>,<?php echo $tech["disabled"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_eta_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_eta(<?php echo $tech["id"]; ?>,0);">enable</a></span></td>
                    <?php } else { ?>
                    <td align="center"><a href="javascript:edit_eta(<?php echo $tech["id"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_eta_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_eta(<?php echo $tech["id"]; ?>,1);">disable</a></span></td>
                    <?php } ?>
                </tr>
                <?php } while($tech = mysqli_fetch_array($techs)); ?>
            </table>
        </td>
        <td width="5%">&nbsp;</td>
    	<td valign="top">
        <table width="100%">
        	<tr>
            	<td><input type="button" value="Add New Eta" onclick="add_new_eta();"/></td>
            </tr>
            <tr>
            	<td id="add_new_eta_field"></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<?php }
?>
