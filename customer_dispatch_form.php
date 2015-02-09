<script language="javascript">

jQuery( document ).ready(function( $ ) {
  
 

  $.ajax
	({
		type: "POST",
		url: "ajax/get_companies.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#company").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_carriers.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#carrier").html(result);
			}
		}
	});
	
  $.ajax
	({
		type: "POST",
		url: "ajax/get_problem_description.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#problem_description").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_states.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#location_state").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_tire_codes.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#tire_codes").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_tire_storage_locations.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#tire_storage_locations").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_tire_sizes.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#tire_sizes").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_etas.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#etas").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_referrals.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#hear_about_us").html(result);
			}
		}
	});
	
	$.ajax
	({
		type: "POST",
		url: "ajax/get_dispatchers.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#dispatchers").html(result);
				disable_fields();
			}
		}
		
	});
	
	$(".fancybox").fancybox({
	  'width' : 1000,
	  'height' : 300,
	  'autoSize' : false,
	  'type' : "iframe"
	});
	
	$(".fancyboxdetails").fancybox({
	  'width' : 1000,
	  'height' : 600,
	  'autoSize' : false,
	  'type' : "iframe"
	});
	
	$(".fancyboxphotos").fancybox({
	  'width' : 1000,
	  'height' : 800,
	  'autoSize' : false,
	  'type' : "iframe"
	});
	
	$(".fancyboxprint").fancybox({
	  'width' : 1100,
	  'height' : 800,
	  'autoSize' : false,
	  'type' : "iframe"
	});
	
});

function disable_fields()
{
	$("#dispatch_form select").attr("disabled", true);
	$("#dispatch_form textarea").attr('disabled', true);
	$("#dispatch_form :input").attr("disabled", true);	
	$("#dispatch_button").attr("disabled", false);
}

function add_tech_dropdown(id)
{
	$.ajax
	({
		type: "POST",
		url: "ajax/add_techs_dispatch.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#techs").html(result);
				$("#dispatch_form :input").attr("disabled", true);
				$("#dispatch_button").attr("disabled", false);
				
				$.ajax
				({
					type: "POST",
					url: "ajax/get_techs.php",
					success: function(result)
					{
						if (result) 
						{ 
							//alert(result);
							$("#techs").html(result);
							$("#dispatch_form :input").attr("disabled", true);
							$("#dispatch_button").attr("disabled", false);
						}
					}
				});	
			}
		}
	});	
	

}

function get_new_RO()
{
	$.ajax
	({
		type: "POST",
		url: "ajax/get_new_RO.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				var res = result.split(",");
				$("#currentRO").val(res[0]);
				$("#RO").html(res[1]);
				$("#dispatch_form :input").attr("disabled", false);
				$("#dispatch_form select").not("#dispatchers_id").val('0');
				<?php if ($_SESSION["userlevel"] == 2) { ?>
				$("#dispatcher_id").attr("disabled", true);
				<?php } ?>
				$("#eta_id option")[1].selected = true;
				
				n = res[1].indexOf('R');
				
				if (n)
				{
					tabs2_click(res[0]);
				} else {
					$("input:text").val('');
					$("textarea").val('');
					$("#update_msg").html('');
				}
				
				//close dispatch
				buttontext = '"&nbsp;&nbsp;<input type="button" value="Close Dispatch" style="margin-top:2px;" onclick="javascript:close_dispatch(' + res[0] + ');"/>';
				$("#close_button").html(buttontext);
				
				//update open dispatches
				
				//check for admin or dispatcher
				<?php if ($_SESSION["userlevel"] == 2) { ?>
				update_dispatch('dispatcher_id', <?php echo $_SESSION["did"]; ?>);
				<?php } else { ?>
				update_dispatch('dispatcher_id', 20);
				<?php } ?>
				
				//add_tech_dropdown();
				update_dispatch('eta_id', 1);
				update_open_dispatches();
				get_tech_dispatches();
			}
		}
	});
	
}

function close_dispatch_reset()
{
	disable_fields();
	$("input:text").val('');
	$("textarea").val('');
	$("#update_msg").html('');
	$("#currentRO").val('');
	$("select").val($("select option:first").val());
	$("#RO").html('<input type="button" id="dispatch_button" value="Open New Dispatch" style="margin-top:2px;" onclick="javascript:get_new_RO();"/>');
				
}

function update_open_dispatches()
{
	$.ajax
	({
		type: "POST",
		url: "ajax/update_close_dispatch.php",
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#open_dispatches").html(result);
			}
		}
	});	
}

function get_tech_dispatches()
{
	updateid = $("#currentRO").val();
	$.ajax
	({
		type: "POST",
		url: "ajax/get_techs.php",
		data: {id : updateid},
		success: function(result)
		{
			if (result) 
			{ 
				$("#techs").html(result);
				update_open_dispatches();
				tabs3_click();
			}
		}
	});	
}

function update_tech(did, pid, val)
{
	if (confirm("Are You Sure?"))
	{
		$.ajax
		({
			type: "POST",
			url: "ajax/update_dispatch_tech.php",
			data: {id : pid, tid : val},
			success: function(result)
			{
				html =  "<font color='blue'>Tech Successfully Updated</font>";
				$("#update_msg").html(html);
				email_tech(val);
				update_open_dispatches();
				tabs3_click();
			}
		});	
	} else {
		$.ajax
		({
			type: "POST",
			url: "ajax/get_techs.php",
			data: {id : did},
			success: function(result)
			{

				$("#tech_id").html(result);

			}
		});	
	}
}

function email_tech(val)
{
	id = $("#currentRO").val();
	if (val > 0)
	{
		$.ajax
		({
			type: "POST",
			url: "ajax/email_tech.php",
			data: {did : id, tid : val},
			success: function(result)
			{
				alert(result);
				html = "Tech Emailed successfully";
				html = $("#update_msg").html() + "<br>" + html;
				$("#update_msg").html(html);
			}
		});	
	}
}

function add_tech(did)
{
	$.ajax
	({
		type: "POST",
		url: "ajax/add_dispatch_tech.php",
		data: {id : did},
		success: function(result)
		{
			get_tech_dispatches();
		}
	});	
}

function delete_tech(did)
{
	$.ajax
	({
		type: "POST",
		url: "ajax/delete_dispatch_tech.php",
		data: {id : did},
		success: function(result)
		{
			//alert(result);
			get_tech_dispatches();
		}
	});	
}

function update_dispatch(field, val)
{
	//alert(field + ", " + val);
	//if (val == 0 || val == "")
	//{
		//alert("Null or ZERO!");
	//} else {
		updateid = $("#currentRO").val();
		
		if (field == "driver_number")
		{

    		 val = val.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
			 $("#driver_number").val(val);

		}
		
		$.ajax
		({
			type: "POST",
			url: "ajax/update_dispatch_field.php",
			data: {id : updateid, fieldname : field, value : val},
			success: function(result)
			{
				if (result) 
				{ 
					//alert(result);
					if (result == "Success")
					{
						html =  "<font color='blue'>Field " + field + " Successfully Updated</font>";
						$("#update_msg").html(html);
					} else {
						html = "<font color='red'>Error Updating Field</font>";
						$("#update_msg").html(html);
					}
				}
			}
		});
		
		if (field == 'company_id')
		{
			$.ajax
			({
				type: "POST",
				url: "ajax/get_company_info.php",
				data: {id : val},
				success: function(result)
				{
					if (result) 
					{ 
						var res = result.split("|");
						$("#company_address").html(res[0]);
						$("#company_phone").html(res[1]);
						$("#company_fax").html(res[2]);
						$("#company_email").html(res[3]);
						$("#company_contact").html(res[4]);
						
						
					}
				}
			});
			update_open_dispatches();
			tabs3_click();
		}
		
		if (field == "carrier_id")
		{
			$.ajax
			({
				type: "POST",
				url: "ajax/get_carrier_info.php",
				data: {id : val},
				success: function(result)
				{
					if (result) 
					{ 
						//alert(result);				
						if (result == 'Black List - DO NOT PROVIDE SERVICE')
						{
							$("#customer_requirements").css({'color':'red', 'font-weight':'bold'});
						} else {
							$("#customer_requirements").css({'color':'black', 'font-weight':'500'});
						}
						$("#customer_requirements").val(result);
					}
				}
			});
			update_open_dispatches();
			tabs3_click();
			
			
		}
		
		if (field == 'dispatcher_id' || field == 'tech_id' || field == 'problem_id' || field == 'eta_id')
		{
			update_open_dispatches();
		}
		
		if (field == 'problem_id' || field == 'address_location' || field == 'city_location' || field == 'state_id' || field == 'zip_location' || field == 'county_location')
		{
			tabs3_click()
		}
	//}
		
}

function reject_call()
{
	
	updateid = $("#currentRO").val();
		reason = $("#reject_reasons_id").val();
		$.ajax
		({
			type: "POST",
			url: "ajax/update_dispatch_reject.php",
			data: {id : updateid, reject_reasons_id : reason},
			success: function(result)
			{
				if (result) 
				{ 
					//alert(result);
					$("#dispatch_form").html(result);
					update_open_dispatches();
					tabs3_click();
					close_dispatch_reset();
				}
			}
		});
}

function delete_photo(pid, original, thumbnail, disid)
{

	$.ajax
	({
		type: "POST",
		url: "ajax/delete_photos.php",
		data: {id : pid, largephoto : original, smallphoto : thumbnail, did : disid},
		success: function(result)
		{
			if (result) 
			{ 
				//alert(result);
				$("#dispatch_photos").html(result);
			}
		}
	});

}
</script>

<div align="center" id="dispatch_form"><input type="hidden" id="currentRO" />
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid BLACK;" >
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                        <td align="left" id="RO" style="font-size:18px; color:green;" colspan="3"><input type="button" id="dispatch_button" value="Open New Dispatch" style="margin-top:2px;" onclick="javascript:get_new_RO();"/></td>
                        <td align="right" id="update_msg" style="font-size:16px; color:blue;" colspan="3"></td>
                    </tr>
                    <tr>
                    	<td colspan="6"><hr /></td>
                    </tr>
                    <tr>
                    	<td align="right"><a class="fancybox" href="add_customer_form.php" style="font-size:9px;">add customer</a>&nbsp;<strong>Company</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company" width="30%">
                         <select name="company_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>Contact</strong>&nbsp;&nbsp;</td>
                        <td align="left"><input type="text" size="25" name="contact" id="contact" onchange="update_dispatch('contact', this.value);"/></td>
                        <td align="right"  ><strong>Phone</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_phone">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="right"><strong>Customer Address</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_address">&nbsp;</td>
                        <td align="right"><strong>Fax</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_fax">&nbsp;</td>
						<td align="right"><strong>Email</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_email">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="right"><a class="fancybox" href="add_customer_form.php" style="font-size:9px;">add carrier</a>&nbsp;<strong>Carrier</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="carrier" width="30%">
                         <select name="carrier_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        </td>
                        <td align="right"  ><strong>Driver Name</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="driver_name" id="driver_name" onchange="update_dispatch('driver_name', this.value);"/></td>
                        <td align="right"  ><strong>Driver #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="driver_number" id="driver_number" onchange="update_dispatch('driver_number', this.value);" class="phone"/></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tractor #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="tractor" id="tractor" onchange="update_dispatch('tractor', this.value);"/></td>
                        <td align="right"  ><strong>Trailer/Container/Chassis #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="trailer" id="trailer" onchange="update_dispatch('trailer', this.value);"/></td>
                        <td align="right"  ><strong>Cust Ref #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="cutomer_ref_num" id="customer_ref_num" onchange="update_dispatch('customer_ref_num', this.value);"/></td>
                    </tr>
                </table>
            </div>
            <div style="border:1px solid BLACK; margin-top:5px;">
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                    	<td align="right"  ><strong>Problem Description</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="problem_description">
                         <select name="problem_description_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>Address/Location</strong>&nbsp;&nbsp;</td>
                        <td align="left" colspan="4"><input type="text" size="72" name="address_location" id="address_location" onchange="update_dispatch('address_location', this.value);"/></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Location City</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="city_location" id="city_location" onchange="update_dispatch('city_location', this.value);"/></td>
                        <td align="right"  ><strong>Location State</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="location_state">
                        <select name="location_state_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>Zip</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="zip_location" id="zip_location" onchange="update_dispatch('zip_location', this.value);"/></td>
                    </tr>
		            <tr>
                    	<td align="right"  ><strong>County</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="county_location" id="county_location" onchange="update_dispatch('county_location', this.value);"/></td>
                        <td align="right"  ><strong>QB Tire Code</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_codes">
                         <select name="tire_codes_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>Tire Storage Loc</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_storage_locations">
                         <select name="tire_storage_locations_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tire Size</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_sizes" colspan="3">
                        <select name="tire_sizes_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>Position</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_postions" >
                        <select name="tire_positions_select" id="tire_position_id" onchange="update_dispatch('tire_position_id', this.value);">
                        	<option value="0">Select One</option>
                            <option value="1">Left Front Outer</option>
                            <option value="2">Left Front Inner</option>
                            <option value="3">Right Front Outer</option>
                            <option value="4">Right Front Inner</option>
                        </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="border:1px solid BLACK; margin-top:5px;">
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                    	<td align="right"  ><strong>ETA (How Long)</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="etas">
                        <select name="etas_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>R/T Mileage</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="round_trip_miles" id="round_trip_miles" onchange="update_dispatch('round_trip_miles', this.value);"/></td>
                        <td align="right">&nbsp;</td>
                        <td align="left" >&nbsp;</td>
                    </tr>
		            <tr>
                    	<td align="right" ><strong>Dispatcher</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="dispatchers">
                        <select name="dispatchers_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right" valign="top"><strong>Techs</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="techs">
                        <select name="techs_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                        <td align="right"  ><strong>How Did You Hear?</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="hear_about_us">
                        <select name="hear_about_us_select">
                        	<option value="0">Select...</option>
                        </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="border:1px solid BLACK; margin-top:5px;">
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                    	<td align="center"><strong>Customer Requirements</strong></td>
                        <td align="center"><strong>Additional Notes</strong></td>
                    </tr>
   		            <tr>
                    	<td align="center"><textarea rows="5" cols="80" name="customer_requirements" id="customer_requirements" readonly="readonly"></textarea></td>
                        <td align="center"><textarea rows="5" cols="80" name="additional_notes" id="additional_notes" onchange="update_dispatch('additional_notes', this.value);"></textarea></td>
                    </tr>
                    <tr>
                    	<td align="center"><strong>Tech Notes</strong></td>
                        <td align="center"><strong>Job Requirements</strong></td>
                    </tr>
   		            <tr>
                    	<td align="center"><textarea rows="5" cols="80" name="tech_notes" id="tech_notes" onchange="update_dispatch('tech_notes', this.value);"></textarea></td>
                        <td align="center"><textarea rows="5" cols="80" name="job_requirements" id="job_requirements" onchange="update_dispatch('job_requirements', this.value);"></textarea></td>
                    </tr>
                </table>
            </div>
           	<input type="button" value="Open New Dispatch" style="margin-top:2px;" onclick="javascript:get_new_RO();"/>
            
        </td>
    </tr>
</table>
</div>

