<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

function add_record($table,$data){

	// fix characters that MySQL doesn't like
	foreach(array_keys($data) as $field_name) {

		
		if (!$field_string) {
			$field_string = "`$field_name`";
			$value_string = "'$data[$field_name]'";
		} else {
			$field_string .= ",`$field_name`";
			$value_string .= ",'$data[$field_name]'";
		}
	}
	
	$query = "INSERT INTO $table ($field_string) VALUES ($value_string)";
	return $query;
}

if ($_POST["id"])
{
	$qry = "UPDATE dispatch SET cancelled = 1, cancelled_reason_id = ".$_POST["reject_reasons_id"]." WHERE id = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
	
	$qry = "SELECT * FROM dispatch WHERE id = ".$_POST["id"];
	
	$rejects = mysqli_query($connection, $qry) or die (mysqli_serror()); 
	$reject = mysqli_fetch_assoc($rejects);
	$reject["id"] = "";
	
	$qry = add_record("dispatch_rejects", $reject);
	//echo $qry;
	mysqli_query($connection, $qry) or die (mysqli_error());
	
	$qry = "DELETE FROM dispatch WHERE id = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
	
	$qry = "INSERT INTO dispatch (id, cancelled) VALUES ('".$_POST["id"]."','1')";
	mysqli_query($connection, $qry) or die (mysqli_error()); 
	
	$qry = "DELETE FROM tech_dispatch WHERE did = ".$_POST["id"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}
?>

<input type="hidden" id="currentRO" value=""/>
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid BLACK;" >
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                        <td align="left" id="RO" style="font-size:18px; color:green;" colspan="3"></td>
                        <td align="right" id="update_msg" style="font-size:16px; color:blue;" colspan="3"></td>
                    </tr>
                    <tr>
                    	<td colspan="6"><hr /></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><a class="fancybox" href="add_customer_form.php" style="font-size:9px;">add customer</a>&nbsp;<strong>Company</strong>&nbsp;&nbsp;</td>
                         <td align="left" id="company" width="30%">
                          <?php include("get_companies.php"); ?>
                        </td>
                        <td align="right"><strong>Contact</strong>&nbsp;&nbsp;</td>
                        <td align="left"><input type="text" size="25" name="contact" id="contact" onchange="update_dispatch('contact', this.value);" value=""/></td>
                        <td align="right"><strong>Phone</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_phone"></td>
                    </tr>
                    <tr>
                    	<td align="right"><strong>Customer Address</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_address"></td>
                        <td align="right"><strong>Fax</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_fax">></td>
						<td align="right"><strong>Email</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="company_email"></td>
                    </tr>
                    <tr>
                    	<td align="right"><a class="fancybox" href="add_customer_form.php" style="font-size:9px;">add carrier</a>&nbsp;<strong>Carrier</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="carrier">
                          <?php include("get_carriers.php"); ?>
                        </td>
                        <td align="right"  ><strong>Driver Name</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="driver_name" id="driver_name" onchange="update_dispatch('driver_name', this.value);" value=""/></td>
                        <td align="right"  ><strong>Driver #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="driver_number" id="driver_number" onchange="update_dispatch('driver_number', this.value);" value=""/></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tractor #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="tractor" id="tractor" onchange="update_dispatch('tractor', this.value);" value=""/></td>
                        <td align="right"  ><strong>Trailer/Container/Chassis #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="trailer" id="trailer" onchange="update_dispatch('trailer', this.value);" value=""/></td>
                        <td align="right"  ><strong>Cust Ref #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="cutomer_ref_num" id="customer_ref_num" onchange="update_dispatch('customer_ref_num', this.value);" value=""/></td>
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
                        <td align="left" colspan="4"><input type="text" size="72" name="address_location" id="address_location" onchange="update_dispatch('address_location', this.value);" value=""/></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Location City</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="city_location" id="city_location" onchange="update_dispatch('city_location', this.value);"  value=""/></td>
                        <td align="right"  ><strong>Location State</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="location_state">
                         <?php include("get_states.php"); ?>
                        </td>
                        <td align="right"  ><strong>Zip</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="zip_location" id="zip_location" onchange="update_dispatch('zip_location', this.value);" value=""/></td>
                    </tr>
		            <tr>
                    	<td align="right"  ><strong>County</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="county_location" id="county_location" onchange="update_dispatch('county_location', this.value);" value=""/></td>
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
                         <?php include("get_etas.php"); ?>
                        </td>
                        <td align="right"  ><strong>R/T Mileage</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><input type="text" size="25" name="round_trip_miles" id="round_trip_miles" onchange="update_dispatch('round_trip_miles', this.value);"  value=""/></td>
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