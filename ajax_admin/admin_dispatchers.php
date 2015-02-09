<?php

if ($_POST["tech_refresh"])
{
	require_once('../db/DB.php');
}

$qry = "SELECT * FROM dispatchers ORDER BY disabled, dispatcher";

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{?>
<script language="javascript">
function edit_dispatcher(tid, stat)
{
	name = $("#dname_" + tid).html();
	email = $("#demail_" + tid).html();
	phone = $("#dphone_" + tid).html();
	
	html = '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'dispatcher\',this.value);" value="'+name+'" id="dname_' + tid + '"></td>';
	html = html + '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'email\',this.value);" value="'+email+'" id="demail_' + tid + '"></td>';
	html = html + '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'phone\',this.value);" value="'+phone+'" id="dphone_' + tid + '"></td>';
	html = html + '<td><em>password hidden</em></td>';
	html = html + '<td align="center"><a href="javascript:unedit_dispatcher(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#dispatcher_" + tid).html(html);
	
}

function edit_dispatch_password(tid, stat)
{
	name = $("#dname_" + tid).html();
	email = $("#demail_" + tid).html();
	phone = $("#dphone_" + tid).html();
	
	html = '<td id="dname_' + tid + '">'+name+'</td>';
	html = html + '<td id="demail_' + tid + '">'+email+'</td>';
	html = html + '<td id="dphone_' + tid + '">'+phone+'</td>';
	html = html + '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'password\',this.value);" id="dpassword_' + tid + '"></td>';
	html = html + '<td align="center"><a href="javascript:unedit_dispatcher(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#dispatcher_" + tid).html(html);
	
}

function unedit_dispatcher(tid,stat)
{
	if ($("#dname_" + tid).val())
	{
		name = $("#dname_" + tid).val();
	} else {
		name = $("#dname_" + tid).html();
	}

	if ($("#demail_" + tid).val())
	{
		email = $("#demail_" + tid).val();
	} else {
		email = $("#demail_" + tid).html();
	}
	
	if ($("#dphone_" + tid).val())
	{
		phone = $("#dphone_" + tid).val();
	} else {
		email = $("#dphone_" + tid).html();
	}
	
	html = '<td id="dname_' + tid + '">'+name+'</td>';
	html = html + '<td id="demail_' + tid + '">'+email+'</td>';
	html = html + '<td id="dphone_' + tid + '">'+phone+'</td>';
	html = html + '<td id="dpassword_' + tid + '" align="center"><a href="javascript:edit_dispatch_password(' + tid + ');">edit</a></td>';
	if (stat == 1)
	{
		html = html + '<td align="center"><a href="javascript:edit_dispatcher('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_'+tid+'"><a href="javascript:enable_disable_dispatcher('+tid+',0);">enable</a></span></td>';
	} else {
		html = html + '<td align="center"><a href="javascript:edit_dispatcher('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_'+tid+'"><a href="javascript:enable_disable_dispatcher('+tid+',1);">disable</a></span></td>';
	}
	
	$("#dispatcher_" + tid).html(html);
	
}

function enable_disable_dispatcher(tid,val)
{
	update_dispatcher_val(tid,'disabled',val);
	
	if (val == 1)
	{
		html = '<a href="javascript:enable_disable_dispatcher('+tid+',0);">enable</a>';
		$("#edit_"+tid).html(html);
		$("#tech_"+tid).css("background-color", "#FF6F6F");
	} else {
		html = '<a href="javascript:enable_disable_dispatcher('+tid+',1);">disable</a>';
		$("#edit_"+tid).html(html);
		$("#tech_"+tid).css("background-color", "WHITE");
	}
	
	finish_new_dispatcher();
}

function update_dispatcher_val(tid, field, val)
{

 	

		$.ajax
		({
			type: "POST",
			url: "ajax/update_dispatcher_field.php",
			data: {id : tid, fieldname : field, value : val},
			success: function(result)
			{
				if (result) 
				{ 
					if (result == "Success")
					{
						html =  "<font color='blue'>Field " + field + " Successfully Updated</font>";
						//alert(result);
						//$("#update_msg").html(html);
					} else {
						html = "<font color='red'>Error Updating Field/font>";
						//alert(result);
						//$("#update_msg").html(html);
					}
				}
			}
		});

}

function add_new_dispatcher()
{

		$.ajax
		({
			type: "POST",
			url: "ajax/add_dispatcher.php",
			success: function(result)
			{
				if (result) 
				{ 
					tid = result;
					
					html = '<table><tr>';
					html = html + '<td><strong>Name</strong></td>';
					html = html + '<td><strong>Email</strong></td>';
					html = html + '<td><strong>Phone</strong></td>';
					html = html + '</tr><tr>';
				 	html = html + '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'dispatcher\',this.value);" id="dname_' + tid + '"></td>';
					html = html + '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'email\',this.value);" id="demail_' + tid + '"></td>';
					html = html + '<td><input type="text" onchange="update_dispatcher_val('+tid+',\'phone\',this.value);" id="dphone_' + tid + '"></td>';
					html = html + '<td align="center"><a href="javascript:finish_new_dispatcher();">FINISHED</a></td>';
					html = html + "</tr></table>";
					$("#add_new_dispatcher_field").html(html);
				}
			}
		});

}

function finish_new_dispatcher()
{
	
	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_dispatchers.php",
			data: {tech_refresh : 1},
			success: function(result)
			{
				if (result) 
				{ 
					$("#tabs-2").html(result);
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
                    <td>Dispatcher Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Password</td>
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
                <tr id = "dispatcher_<?php echo $tech["id"]; ?>" <?php if ($tech["disabled"]) {?> bgcolor="#FF6F6F" <?php } else { ?>bgcolor="<?php echo $bgcolor; ?>" <?php } ?>>
                    <td id="dname_<?php echo $tech["id"]; ?>"><?php echo $tech["dispatcher"]; ?></td>
                    <td id="demail_<?php echo $tech["id"]; ?>"><?php echo $tech["email"]; ?></td>
                    <td id="dphone_<?php echo $tech["id"]; ?>"><?php echo $tech["phone"]; ?></td>
                    <td id="dpassword_<?php echo $tech["id"]; ?>" align="center"><a href="javascript:edit_dispatch_password(<?php echo $tech["id"]; ?>);">edit</a></td>
                    <?php if ($tech["disabled"]) { ?>
                     <td align="center"><a href="javascript:edit_dispatcher(<?php echo $tech["id"]; ?>,<?php echo $tech["disabled"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_dispatcher(<?php echo $tech["id"]; ?>,0);">enable</a></span></td>
                    <?php } else { ?>
                    <td align="center"><a href="javascript:edit_dispatcher(<?php echo $tech["id"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable_dispatcher(<?php echo $tech["id"]; ?>,1);">disable</a></span></td>
                    <?php } ?>
                </tr>
                <?php } while($tech = mysqli_fetch_array($techs)); ?>
            </table>
        </td>
        <td width="5%">&nbsp;</td>
    	<td valign="top">
        <table width="100%">
        	<tr>
            	<td><input type="button" value="Add New Dispatcher" onclick="add_new_dispatcher();"/></td>
            </tr>
            <tr>
            	<td id="add_new_dispatcher_field"></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<?php }
?>
