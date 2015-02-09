<?php

if ($_POST["tech_refresh"])
{
	require_once('../db/DB.php');
}

$qry = "SELECT * FROM problems ORDER BY disabled, id";

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{?>
<script language="javascript">
function edit_problem(tid, stat)
{
	name = $("#problem_name_" + tid).html();
	
	html = '<td><input type="text" onchange="update_problem_val('+tid+',\'problem\',this.value);" value="'+name+'" id="problem_name_' + tid + '"></td>';
	html = html + '<td align="center"><a href="javascript:unedit_problem(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#problem_" + tid).html(html);
	
}

function unedit_problem(tid,stat)
{

	if ($("#problem_name_" + tid).val())
	{
		name = $("#problem_name_" + tid).val();
	} else {
		name = $("#problem_name_" + tid).html();
	}

	
	html = '<td id="problem_name_' + tid + '">'+name+'</td>';
	if (stat == 1)
	{
		html = html + '<td align="center"><a href="javascript:edit_problem('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_problem_'+tid+'"><a href="javascript:enable_disable_problem('+tid+',0);">enable</a></span></td>';
	} else {
		html = html + '<td align="center"><a href="javascript:edit_problem('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_problem_'+tid+'"><a href="javascript:enable_disable_problem('+tid+',1);">disable</a></span></td>';
	}
	
	$("#problem_" + tid).html(html);
	
}

function enable_disable_problem(tid,val)
{
	update_problem_val(tid,'disabled',val);
	
	if (val == 1)
	{
		html = '<a href="javascript:enable_disable_problem('+tid+',0);">enable</a>';
		$("#edit_problem_"+tid).html(html);
		$("#problem_"+tid).css("background-color", "#FF6F6F");
	} else {
		html = '<a href="javascript:enable_disable_problem('+tid+',1);">disable</a>';
		$("#edit_problem_"+tid).html(html);
		$("#problem_"+tid).css("background-color", "WHITE");
	}
	
	finish_new_problem_status();
}

function update_problem_val(tid, field, val)
{

 	

		$.ajax
		({
			type: "POST",
			url: "ajax/update_problem_field.php",
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

function add_new_problem()
{

		$.ajax
		({
			type: "POST",
			url: "ajax/add_problems.php",
			success: function(result)
			{
				if (result) 
				{ 
					tid = result;
					
					html = '<table><tr>';
					html = html + '<td><strong>Name</strong></td>';
					html = html + '</tr><tr>';
				 	html = html + '<td><input type="text" onchange="update_problem_val('+tid+',\'problem\',this.value);" id="problem_name_' + tid + '"></td>';
					html = html + '<td align="center"><a href="javascript:finish_new_problem_status();">FINISHED</a></td>';
					html = html + "</tr></table>";
					$("#add_new_problem_field").html(html);
				}
			}
		});

}

function finish_new_problem_status()
{
	
	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_problems.php",
			data: {tech_refresh : 1},
			success: function(result)
			{
				if (result) 
				{ 
					$("#tabs-4").html(result);
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
                    <td>Problems</td>
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
                <tr id = "problem_<?php echo $tech["id"]; ?>" <?php if ($tech["disabled"]) {?> bgcolor="#FF6F6F" <?php } else { ?>bgcolor="<?php echo $bgcolor; ?>" <?php } ?>>
                    <td id="problem_name_<?php echo $tech["id"]; ?>"><?php echo $tech["problem"]; ?></td>
                    <?php if ($tech["disabled"]) { ?>
                     <td align="center"><a href="javascript:edit_problem(<?php echo $tech["id"]; ?>,<?php echo $tech["disabled"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_problem_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_problem(<?php echo $tech["id"]; ?>,0);">enable</a></span></td>
                    <?php } else { ?>
                    <td align="center"><a href="javascript:edit_problem(<?php echo $tech["id"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_problem_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_problem(<?php echo $tech["id"]; ?>,1);">disable</a></span></td>
                    <?php } ?>
                </tr>
                <?php } while($tech = mysqli_fetch_array($techs)); ?>
            </table>
        </td>
        <td width="5%">&nbsp;</td>
    	<td valign="top">
        <table width="100%">
        	<tr>
            	<td><input type="button" value="Add New Problem" onclick="add_new_problem();"/></td>
            </tr>
            <tr>
            	<td id="add_new_problem_field"></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<?php }
?>
