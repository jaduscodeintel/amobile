<?php

if ($_POST["tech_refresh"])
{
	require_once('../db/DB.php');
}

$qry = "SELECT * FROM techs ORDER BY disabled, name";

$techs = mysqli_query($connection, $qry) or die (mysqli_error()); 
$tech = mysqli_fetch_array($techs);

if ($tech)
{?>
<script language="javascript">
function edit_tech(tid, stat)
{
	name = $("#name_" + tid).html();
	email = $("#email_" + tid).html();
	phone = $("#phone_" + tid).html();
	
	html = '<td><input type="text" onchange="update_tech_val('+tid+',\'name\',this.value);" value="'+name+'" id="name_' + tid + '"></td>';
	html = html + '<td><input type="text" onchange="update_tech_val('+tid+',\'email\',this.value);" value="'+email+'" id="email_' + tid + '"></td>';
	html = html + '<td><input type="text" onchange="update_tech_val('+tid+',\'phone\',this.value);" value="'+phone+'" id="phone_' + tid + '"></td>';
	html = html + '<td><em>password hidden</em></td>';
	html = html + '<td align="center"><a href="javascript:unedit_tech(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#tech_" + tid).html(html);
	
}

function edit_tech_password(tid, stat)
{
	name = $("#name_" + tid).html();
	email = $("#email_" + tid).html();
	phone = $("#phone_" + tid).html();
	
	html = '<td id="name_' + tid + '">'+name+'</td>';
	html = html + '<td id="email_' + tid + '">'+email+'</td>';
	html = html + '<td id="phone_' + tid + '">'+phone+'</td>';
	html = html + '<td><input type="text" onchange="update_tech_val('+tid+',\'password\',this.value);" id="password_' + tid + '"></td>';
	html = html + '<td align="center"><a href="javascript:unedit_tech(' + tid + ','+stat+')">FINISHED</a></td>';
	
	$("#tech_" + tid).html(html);
	
}

function unedit_tech(tid,stat)
{

	if ($("#name_" + tid).val())
	{
		name = $("#name_" + tid).val();
	} else {
		name = $("#name_" + tid).html();
	}

	if ($("#email_" + tid).val())
	{
		email = $("#email_" + tid).val();
	} else {
		email = $("#email_" + tid).html();
	}
	
	if ($("#phone_" + tid).val())
	{
		phone = $("#phone_" + tid).val();
	} else {
		phone = $("#phone_" + tid).html();
	}
	
	html = '<td id="name_' + tid + '">'+name+'</td>';
	html = html + '<td id="email_' + tid + '">'+email+'</td>';
	html = html + '<td id="phone_' + tid + '">'+phone+'</td>';
	html = html + '<td id="password_' + tid + '" align="center"><a href="javascript:edit_tech_password(' + tid + ');">edit</a></td>';
	if (stat == 1)
	{
		html = html + '<td align="center"><a href="javascript:edit_tech('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_'+tid+'"><a href="javascript:enable_disable('+tid+',0);">enable</a></span></td>';
	} else {
		html = html + '<td align="center"><a href="javascript:edit_tech('+tid+');">edit</a>&nbsp;&nbsp;<span id="edit_'+tid+'"><a href="javascript:enable_disable('+tid+',1);">disable</a></span></td>';
	}
	
	$("#tech_" + tid).html(html);
	
}

function enable_disable(tid,val)
{
	update_tech_val(tid,'disabled',val);
	
	if (val == 1)
	{
		html = '<a href="javascript:enable_disable('+tid+',0);">enable</a>';
		$("#edit_"+tid).html(html);
		$("#tech_"+tid).css("background-color", "#FF6F6F");
	} else {
		html = '<a href="javascript:enable_disable('+tid+',1);">disable</a>';
		$("#edit_"+tid).html(html);
		$("#tech_"+tid).css("background-color", "WHITE");
	}
	
	finish_new_tech();
}

function update_tech_val(tid, field, val)
{

 	

		$.ajax
		({
			type: "POST",
			url: "ajax/update_tech_field.php",
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

function add_new_tech()
{

		$.ajax
		({
			type: "POST",
			url: "ajax/add_tech.php",
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
				 	html = html + '<td><input type="text" onchange="update_tech_val('+tid+',\'name\',this.value);" id="name_' + tid + '"></td>';
					html = html + '<td><input type="text" onchange="update_tech_val('+tid+',\'email\',this.value);" id="email_' + tid + '"></td>';
					html = html + '<td><input type="text" onchange="update_tech_val('+tid+',\'phone\',this.value);" id="phone_' + tid + '"></td>';
					html = html + '<td align="center"><a href="javascript:finish_new_tech();">FINISHED</a></td>';
					html = html + "</tr></table>";
					$("#add_new_tech_field").html(html);
				}
			}
		});

}

function finish_new_tech()
{
	
	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_techs.php",
			data: {tech_refresh : 1},
			success: function(result)
			{
				if (result) 
				{ 
					$("#tabs-1").html(result);
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
                    <td>Tech Name</td>
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
                <tr id = "tech_<?php echo $tech["id"]; ?>" <?php if ($tech["disabled"]) {?> bgcolor="#FF6F6F" <?php } else { ?>bgcolor="<?php echo $bgcolor; ?>" <?php } ?>>
                    <td id="name_<?php echo $tech["id"]; ?>"><?php echo $tech["name"]; ?></td>
                    <td id="email_<?php echo $tech["id"]; ?>"><?php echo $tech["email"]; ?></td>
                    <td id="phone_<?php echo $tech["id"]; ?>"><?php echo $tech["phone"]; ?></td>
                    <td id="password_<?php echo $tech["id"]; ?>" align="center"><a href="javascript:edit_tech_password(<?php echo $tech["id"]; ?>);">edit</a></td>
                    <?php if ($tech["disabled"]) { ?>
                     <td align="center"><a href="javascript:edit_tech(<?php echo $tech["id"]; ?>,<?php echo $tech["disabled"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable(<?php echo $tech["id"]; ?>,0);">enable</a></span></td>
                    <?php } else { ?>
                    <td align="center"><a href="javascript:edit_tech(<?php echo $tech["id"]; ?>);">edit</a>&nbsp;&nbsp;<span id="edit_<?php echo $tech["id"]; ?>"><a href="javascript:enable_disable(<?php echo $tech["id"]; ?>,1);">disable</a></span></td>
                    <?php } ?>
                </tr>
                <?php } while($tech = mysqli_fetch_array($techs)); ?>
            </table>
        </td>
        <td width="5%">&nbsp;</td>
    	<td valign="top">
        <table width="100%">
        	<tr>
            	<td><input type="button" value="Add New Tech" onclick="add_new_tech();"/></td>
            </tr>
            <tr>
            	<td id="add_new_tech_field"></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
<?php }
?>
