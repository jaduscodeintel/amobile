<?php

if ($_POST["tech_refresh"])
{
	require_once('../db/DB.php');
}

$qry = "SELECT * FROM rejected_reasons ORDER BY disabled, id";

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{?>
<script language="javascript">
function edit_reason(tid, stat)
{
	name = $("#reason_name_" + tid).html();
	
	html = '<td><input type="text" onchange="update_reason_val('+tid+',\'reason\',this.value);" value="'+name+'" id="reason_name_' + tid + '" size="60"></td>';
	html = html + '<td align="center"><a href="javascript:unedit_reason(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#reason_" + tid).html(html);
	
}

function unedit_reason(tid,stat)
{

	if ($("#reason_name_" + tid).val())
	{
		name = $("#reason_name_" + tid).val();
	} else {
		name = $("#reason_name_" + tid).html();
	}

		
	html = '<td id="reason_name_' + tid + '">'+name+'</td>';
	
	if (stat == 1)
	{
		html = html + '<td align="center"><a href="javascript:edit_reason('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_reason_'+tid+'"><a href="javascript:enable_disable_reason('+tid+',0);">enable</a></span></td>';
	} else {
		html = html + '<td align="center"><a href="javascript:edit_reason('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_reason_'+tid+'"><a href="javascript:enable_disable_reason('+tid+',1);">disable</a></span></td>';
	}
	
	$("#reason_" + tid).html(html);
	
}

function enable_disable_reason(tid,val)
{
	update_reason_val(tid,'disabled',val);
	
	if (val == 1)
	{
		html = '<a href="javascript:enable_disable_reason('+tid+',0);">enable</a>';
		$("#edit_reason_"+tid).html(html);
		$("#reason_"+tid).css("background-color", "#FF6F6F");
	} else {
		html = '<a href="javascript:enable_disable_reason('+tid+',1);">disable</a>';
		$("#edit_reason_"+tid).html(html);
		$("#reason_"+tid).css("background-color", "WHITE");
	}
	
	finish_new_reason_status();
}

function update_reason_val(tid, field, val)
{

 	

		$.ajax
		({
			type: "POST",
			url: "ajax/update_reject_reason_field.php",
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

function add_new_reject_reason()
{

		$.ajax
		({
			type: "POST",
			url: "ajax/add_reject_reasons.php",
			success: function(result)
			{
				if (result) 
				{ 
					tid = result;
					
					html = '<table><tr>';
					html = html + '<td><strong>Reason</strong></td>';
					html = html + '</tr><tr>';
				 	html = html + '<td><input type="text" onchange="update_reason_val('+tid+',\'reason\',this.value);" id="reason_name_' + tid + '"></td>';
					html = html + '<td align="center"><a href="javascript:finish_new_reason_status();">FINISHED</a></td>';
					html = html + "</tr></table>";
					$("#add_new_reason_field").html(html);
				}
			}
		});

}

function finish_new_reason_status()
{
	
	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_reject_reasons.php",
			data: {tech_refresh : 1},
			success: function(result)
			{
				if (result) 
				{ 
					$("#tabs-9").html(result);
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
                    <td>Reason</td>
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
                <tr id = "reason_<?php echo $tech["id"]; ?>" <?php if ($tech["disabled"]) {?> bgcolor="#FF6F6F" <?php } else { ?>bgcolor="<?php echo $bgcolor; ?>" <?php } ?>>
                    <td id="reason_name_<?php echo $tech["id"]; ?>"><?php echo $tech["reason"]; ?></td>
                    <?php if ($tech["disabled"]) { ?>
                     <td align="center"><a href="javascript:edit_reason(<?php echo $tech["id"]; ?>,<?php echo $tech["disabled"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_reason_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_reason(<?php echo $tech["id"]; ?>,0);">enable</a></span></td>
                    <?php } else { ?>
                    <td align="center"><a href="javascript:edit_reason(<?php echo $tech["id"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_reason_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_reason(<?php echo $tech["id"]; ?>,1);">disable</a></span></td>
                    <?php } ?>
                </tr>
                <?php } while($tech = mysqli_fetch_array($techs)); ?>
            </table>
        </td>
        <td width="5%">&nbsp;</td>
    	<td valign="top">
        <table width="100%">
        	<tr>
            	<td><input type="button" value="Add New Reject Reason" onclick="add_new_reject_reason();"/></td>
            </tr>
            <tr>
            	<td id="add_new_reason_field"></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<?php }
?>
