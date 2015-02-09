<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT customers.address,customers.phone,customers.fax,customers.email,customers.customer_communications, customers.dispatch_notes, dispatch.* FROM dispatch LEFT JOIN customers ON (customers.id = dispatch.company_id) WHERE dispatch.id = ".$_POST["id"];

$dispatches = mysqli_query($connection, $qry) or die (mysqli_error()); 
$dispatch = mysqli_fetch_array($dispatches);

if ($dispatch)
{
	
	$ro = "&nbsp;&nbsp;".$dispatch["RO"];
	$currentdate = date('l F jS Y h:i:s A', strtotime($dispatch["date_time"]));
	
?>
<input type="hidden" id="currentRO" value="<?php echo $dispatch["id"]; ?>"/>
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid BLACK;" >
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                        <td align="left" id="RO" style="font-size:18px; color:green;" colspan="3"><?php echo $ro."&nbsp;&nbsp;<span style='font-size:12px; color:black; font-weight:bold;'>" .$currentdate."</span>";?></td>
                        <td align="right" id="update_msg" style="font-size:16px; color:blue;" colspan="3"></td>
                    </tr>
                    <tr>
                    	<td colspan="6"><hr /></td>
                    </tr>
                    <tr>
                    	<td align="right"><a class="fancybox" href="add_customer_form.php?id=<?php echo $dispatch["id"]; ?>" style="font-size:9px;">add customer</a>&nbsp;<strong>Company</strong>&nbsp;&nbsp;</td>
                         <td align="left" id="company" width="30%">
                          <?php include("get_companies.php"); ?>
                        </td>
                        <td align="right"><strong>Contact</strong>&nbsp;&nbsp;</td>
                        <td align="left"><input type="text" size="25" name="contact" id="contact" onchange="update_dispatch('contact', this.value);" value="<?php echo $dispatch["contact"]; ?>"/></td>
                        <td align="right"><strong>Phone</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_phone"><?php echo $dispatch["phone"]; ?></td>
                    </tr>
                    <tr>
                    	<td align="right"><strong>Customer Address</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_address"><?php echo $dispatch["address"]; ?></td>
                        <td align="right"><strong>Fax</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_fax"><?php echo $dispatch["fax"]; ?></td>
						<td align="right"><strong>Email</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_email"><?php echo $dispatch["email"]; ?></td>
                    </tr>
                    <tr>
                    	<td align="right"><a class="fancybox" href="add_customer_form.php?id=<?php echo $dispatch["id"]; ?>&carrier=1" style="font-size:9px;">add carrier</a>&nbsp;<strong>Carrier</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="carrier">
                          <?php include("get_carriers.php"); ?>
                        </td>
                        <td align="right"  ><strong>Driver Name</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="driver_name" id="driver_name" onchange="update_dispatch('driver_name', this.value);" value="<?php echo $dispatch["driver_name"]; ?>"/></td>
                        <td align="right"  ><strong>Driver #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="driver_number" id="driver_number" onchange="update_dispatch('driver_number', this.value);" value="<?php echo $dispatch["driver_number"]; ?>"/></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tractor #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="tractor" id="tractor" onchange="update_dispatch('tractor', this.value);" value="<?php echo $dispatch["tractor"]; ?>"/></td>
                        <td align="right"  ><strong>Trailer/Container/Chassis #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="trailer" id="trailer" onchange="update_dispatch('trailer', this.value);" value="<?php echo $dispatch["trailer"]; ?>"/></td>
                        <td align="right"  ><strong>Cust Ref #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="cutomer_ref_num" id="customer_ref_num" onchange="update_dispatch('customer_ref_num', this.value);" value="<?php echo $dispatch["customer_ref_num"]; ?>"/></td>
                    </tr>
                </table>
            </div>
            <div style="border:1px solid BLACK; margin-top:5px;">
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                    	<td align="right"  ><strong>Problem Description</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="problem_description">
                         <?php include("get_problem_description.php"); ?>
                        </td>
                        <td align="right"  ><strong>Address/Location</strong>&nbsp;&nbsp;</td>
                        <td align="left" colspan="4"><input type="text" size="72" name="address_location" id="address_location" onchange="update_dispatch('address_location', this.value);" value="<?php echo $dispatch["address_location"]; ?>"/></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Location City</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="city_location" id="city_location" onchange="update_dispatch('city_location', this.value);"  value="<?php echo $dispatch["city_location"]; ?>"/></td>
                        <td align="right"  ><strong>Location State</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="location_state">
                         <?php include("get_states.php"); ?>
                        </td>
                        <td align="right"  ><strong>Zip</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="zip_location" id="zip_location" onchange="update_dispatch('zip_location', this.value);" value="<?php echo $dispatch["zip_location"]; ?>"/></td>
                    </tr>
		            <tr>
                    	<td align="right"  ><strong>County</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="county_location" id="county_location" onchange="update_dispatch('county_location', this.value);" value="<?php echo $dispatch["county_location"]; ?>"/></td>
                        <td align="right"  ><strong>QB Tire Code</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_codes">
						 <?php include("get_tire_codes.php"); ?>
                        </td>
                        <td align="right"  ><strong>Tire Storage Loc</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_storage_locations">
                         <?php include("get_tire_storage_locations.php"); ?>
                        </td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tire Size</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_sizes" colspan="3">
                         <?php include("get_tire_sizes.php"); ?>
                        </td>
                        <td align="right"  ><strong>Position</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_postions" >
                        <select name="tire_positions_select" id="tire_position_id" onchange="update_dispatch('tire_position_id', this.value);">
                        	<option value="0">Select One</option>
                            <option value="1" <?php if ($dispatch["tire_position_id"] == 1) { ?>selected="selected"<?php } ?>>Left Front Outer</option>
                            <option value="2" <?php if ($dispatch["tire_position_id"] == 2) { ?>selected="selected"<?php } ?>>Left Front Inner</option>
                            <option value="3" <?php if ($dispatch["tire_position_id"] == 3) { ?>selected="selected"<?php } ?>>Right Front Outer</option>
                            <option value="4" <?php if ($dispatch["tire_position_id"] == 4) { ?>selected="selected"<?php } ?>>Right Front Inner</option>
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
                         <?php include("get_etas.php"); ?>
                        </td>
                        <td align="right"  ><strong>R/T Mileage</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="round_trip_miles" id="round_trip_miles" onchange="update_dispatch('round_trip_miles', this.value);"  value="<?php echo $dispatch["round_trip_miles"]; ?>"/></td>
                        <td align="right">&nbsp;</td>
                        <td align="left" >&nbsp;</td>
                    </tr>
		            <tr>
                    	<td align="right" ><strong>Dispatcher</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="dispatchers">
                         <?php include("get_dispatchers.php"); ?>
                        </td>
                        <td align="right" valign="top"><strong>Techs</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="techs">
                          <?php include("get_techs.php"); ?>
                        </td>
                        <td align="right"  ><strong>How Did You Hear?</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="hear_about_us">
                         <?php include("get_referrals.php"); ?>
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
                    	<td align="center"><textarea rows="5" cols="80" name="customer_requirements" id="customer_requirements" readonly="readonly"><?php echo str_replace( "<br />", '', $dispatch["dispatch_notes"] ); ?></textarea></td>
                        <td align="center"><textarea rows="5" cols="80" name="additional_notes" id="additional_notes" onchange="update_dispatch('additional_notes', this.value);"><?php echo str_replace( "<br />", '', $dispatch["additional_notes"] ); ?></textarea></td>
                    </tr>
                     <tr>
                    	<td align="center"><strong>Tech Notes</strong></td>
                        <td align="center"><strong>Job Requirements</strong></td>
                    </tr>
   		            <tr>
                    	<td align="center"><textarea rows="5" cols="80" name="tech_notes" id="tech_notes" onchange="update_dispatch('tech_notes', this.value);"><?php echo str_replace( "<br />", '', $dispatch["tech_notes"] ); ?></textarea></td>
                        <td align="center"><textarea rows="5" cols="80" name="job_requirements" id="job_requirements" onchange="update_dispatch('job_requirements', this.value);"><?php echo str_replace( "<br />", '', $dispatch["job_requirements"] ); ?></textarea></td>
                    </tr>
                    <tr>
                    	<td colspan="4"><div id="dispatch_photos"><?php include("get_dispatch_photos.php"); ?></div></td>
                    </tr>
                </table>
            </div>
           	<div style="float:left;"><input type="button" value="Open New Dispatch" style="margin-top:2px;" onclick="javascript:get_new_RO();"/>&nbsp;&nbsp;<input type="button" id="close_button" value="Finished" style="margin-top:2px;" onclick="javascript:close_dispatch_reset();"/>&nbsp;&nbsp;<a  class="fancyboxprint" href="ajax/get_print_form.php?id=<?php echo $dispatch["id"]; ?>"><input type="button" value="Print Dispatch Form" id="print_button" style="margin-top:2px;"/></a></div><div style="float:right;"><?php include("get_reject_reasons.php"); ?>&nbsp;&nbsp;<input type="button" value="Reject Call" style="margin-top:2px;" onclick="javascript:reject_call();"/></div>
            
        </td>
    </tr>
</table>

<?php } ?>