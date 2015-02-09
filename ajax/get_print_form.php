<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

$qry = "SELECT referral_type.referral, techs.name as tname, dispatchers.dispatcher, etas.eta, tire_sizes.tire_size, tire_storage_locations.tire_storage_location, tire_codes.tire_code, states.name as sname, problems.problem, c2.name AS crname, customers.address,customers.phone,customers.fax,customers.email,customers.customer_communications, customers.dispatch_notes, customers.name AS cname, dispatch.* FROM dispatch 
LEFT JOIN customers ON (customers.id = dispatch.company_id)
LEFT JOIN customers as c2 ON (c2.id = dispatch.carrier_id) 
LEFT JOIN problems on (problems.id = dispatch.problem_id)
LEFT JOIN states on (states.id = dispatch.state_id)
LEFT JOIN tire_codes on (tire_codes.id = dispatch.tire_code_id)
LEFT JOIN tire_storage_locations ON (tire_storage_locations.id = dispatch.tire_storage_id)
LEFT JOIN tire_sizes ON (tire_sizes.id = dispatch.tire_size_id)
LEFT JOIN etas ON (etas.id = dispatch.eta_id)
LEFT JOIN dispatchers ON (dispatchers.id = dispatch.dispatcher_id)
LEFT JOIN tech_dispatch ON (tech_dispatch.did = dispatch.id)
LEFT JOIN techs ON (tech_dispatch.tid = techs.id)
LEFT JOIN referral_type ON (referral_type.id = dispatch.how_did_you_hear_id)
WHERE dispatch.id = ".$_REQUEST["id"]." LIMIT 1";

//$_POST["id"];

$dispatches = mysqli_query($connection, $qry) or die (mysqli_error()); 
$dispatch = mysqli_fetch_array($dispatches);

$qry = "SELECT * FROM images_dispatch WHERE did = ".$dispatch["id"]." ORDER BY id";
$images = mysqli_query($connection, $qry) or die (mysqli_error()); 
$image = mysqli_fetch_array($images);
	
if ($dispatch)
{
	
	$ro = "&nbsp;&nbsp;".$dispatch["RO"];
	$currentdate = date('l F jS Y h:i:s A', strtotime($dispatch["date_time"]));
?>
<input type="hidden" id="currentRO" value="<?php echo $dispatch["id"]; ?>"/>

<link href="print.css" rel="stylesheet" type="text/css" media="print" />
<table width="1100" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid BLACK;" >
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                        <td align="left" id="RO" style="font-size:30px; color:green;" colspan="3"><?php echo $ro."&nbsp;&nbsp;<span style='font-size:12px; color:black; font-weight:bold;'>" .$currentdate."</span>"; ?></td>
                        <td align="right" id="update_msg" style="font-size:16px; color:blue;" colspan="3"></td>
                    </tr>
                    <tr>
                    	<td colspan="6"><hr /></td>
                    </tr>
                    <tr>
                    	<td align="right"><strong>Company</strong>&nbsp;&nbsp;</td>
                         <td align="left" id="company" width="30%">
                          <?php echo $dispatch["cname"]; ?>
                        </td>
                        <td align="right"><strong>Contact</strong>&nbsp;&nbsp;</td>
                        <td align="left"><?php echo $dispatch["contact"]; ?></td>
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
                    	<td align="right"><strong>Carrier</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="carrier"><?php echo $dispatch["crname"]; ?></td>
                        <td align="right"  ><strong>Driver Name</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["driver_name"]; ?></td>
                        <td align="right"  ><strong>Driver #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["driver_number"]; ?></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tractor #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["tractor"]; ?></td>
                        <td align="right"  ><strong>Trailer/Container/Chassis #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["trailer"]; ?></td>
                        <td align="right"  ><strong>Cust Ref #</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["customer_ref_num"]; ?></td>
                    </tr>
                </table>
            </div>
            <div style="border:1px solid BLACK; margin-top:5px;">
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                    	<td align="right"  ><strong>Problem Description</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="problem_description"><?php echo $dispatch["problem"]; ?></td>
                        <td align="right"  ><strong>Address/Location</strong>&nbsp;&nbsp;</td>
                        <td align="left" colspan="4"><?php echo $dispatch["address_location"]; ?></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Location City</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["city_location"]; ?></td>
                        <td align="right"  ><strong>Location State</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="location_state"><?php echo $dispatch["sname"]; ?></td>
                        <td align="right"  ><strong>Zip</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["zip_location"]; ?></td>
                    </tr>
		            <tr>
                    	<td align="right"  ><strong>County</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["county_location"]; ?></td>
                        <td align="right"  ><strong>QB Tire Code</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_codes"><?php echo $dispatch["tire_code"]; ?></td>
                        <td align="right"  ><strong>Tire Storage Loc</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_storage_locations"><?php echo $dispatch["tire_storage_location"]; ?></td>
                    </tr>
                    <tr>
                    	<td align="right"  ><strong>Tire Size</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_sizes" colspan="3"><?php echo $dispatch["tire_size"]; ?></td>
                        <td align="right"  ><strong>Position</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="tire_postions" >
						<?php if ($dispatch["tire_position_id"] == 1) { ?>Left Front Outer<?php } ?>									 						<?php if ($dispatch["tire_position_id"] == 2) { ?>Left Front Inner<?php } ?>
                        <?php if ($dispatch["tire_position_id"] == 3) { ?>Right Front Outer<?php } ?>
                        <?php if ($dispatch["tire_position_id"] == 4) { ?>Right Front Inner<?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="border:1px solid BLACK; margin-top:5px;">
            	<table width="98%" border="0" cellpadding="1" cellspacing="1" style="padding-top:5px; padding-bottom:5px;">
                	<tr>
                    	<td align="right"  ><strong>ETA (How Long)</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="etas"><?php echo $dispatch["eta"]; ?></td>
                        <td align="right"  ><strong>R/T Mileage</strong>&nbsp;&nbsp;</td>
                        <td align="left" ><?php echo $dispatch["round_trip_miles"]; ?></td>
                        <td align="right">&nbsp;</td>
                        <td align="left" >&nbsp;</td>
                    </tr>
		            <tr>
                    	<td align="right" ><strong>Dispatcher</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="dispatchers"><?php echo $dispatch["dispatcher"]; ?></td>
                        <td align="right" valign="top"><strong>Techs</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="techs"><?php echo $dispatch["tname"]; ?></td>
                        <td align="right"  ><strong>How Did You Hear?</strong>&nbsp;&nbsp;</td>
                        <td align="left" id="hear_about_us"><?php echo $dispatch["referral"]; ?></td>
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
                    	<td align="left" width="50%" style="border:1px solid grey; margin-top:5px;"><?php echo $dispatch["dispatch_notes"]; ?></td>
                        <td align="left" width="50%" style="border:1px solid grey; margin-top:5px;"><?php echo $dispatch["additional_notes"]; ?></td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                         	<div align="center"><hr><br />
                            
                            <?php if ($image)
                            {
                                do {
                                    echo '<img src="../uploads/uploads/'.$image["thumbnail_image"].'" alt="Thumbnail">&nbsp;';
                                } while ($image = mysqli_fetch_array($images));
                            } else {
                                echo "<h2>NO IMAGES UPLOADED</h2>";
                            } ?>
                            
                           <br><hr></div>
                        </td>
                </table>
            </div>
           	<div class="noprint">
            <input type="button"
            onClick="window.print()"
            value="Print"/>
            </div>
        </td>
    </tr>
</table>

<?php } ?>