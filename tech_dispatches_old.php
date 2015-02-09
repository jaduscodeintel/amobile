<?php
$qry = "SELECT customers.name AS cname, dispatch.*, tire_sizes.tire_size, problems.problem FROM dispatch 
LEFT JOIN problems ON (problems.id = dispatch.problem_id) 
LEFT JOIN tire_sizes ON (tire_sizes.id = dispatch.tire_size_id) 
LEFT JOIN customers ON (customers.id = dispatch.company_id)
WHERE open = '1' ORDER BY id DESC";
$dispatches = mysqli_query($connection, $qry); 
$dispatch = mysqli_fetch_array($dispatches);

?>
<div align="center" id="tech_dispatches">
<table width="1200" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">

    <tr>
    	<td style="padding:5px;" valign="middle">
        	<div style="border:1px solid RED;" >
            <?php if ($dispatch) { ?>
            <table width="98%" align="center">
            	<tr bgcolor="#999999" style="font-weight:bold;">
	               	<td>RO Number</td>
                    <td>Company Name</td>
                    <td>Tractor/Trailer #</td>
                    <td>Problem Description</td>
                    <td>Tire Info</td>
                    <td>Address</td>
                    <td>Driver Name/Number</td>
                    <td>Special Instructions</td>
                </tr>
                <?php do {	?>
                <tr>
                	<td><a href="#" onclick="tabs2_click(<?php echo $dispatch["id"]; ?>);"><?php echo $dispatch["RO"]; ?></a></td>
                    <td><?php echo $dispatch["cname"]; ?></td>
                    <td><?php echo $dispatch["tractor"]; ?><?php if ($dispatch["trailer"]) { echo "/".$dispatch["trailer"]; }?></td>
                    <td><?php echo $dispatch["problem"]; ?></td>
                    <td>
                    	<?php 
						if ($dispatch["tire_size"]) 
						{
							 echo $dispatch["tire_size"];
					    } else { 
							echo "No Tires"; 
						} ?>
                    </td>
                    <td><?php echo $dispatch["address_location"]."<BR>".$dispatch["city_location"].", ".$dispatch["state_location"]." ".$dispatch["zip_location"]."<BR>".$dispatch["county_location"]; ?></td>
                    <td><?php echo $dispatch["driver_name"]; ?><?php if ($dispatch["trailer"]) { echo "/".$dispatch["driver_number"]; }?></td>
                    <td><a href="#">Special Instructions</a></td>
				</tr>
                <?php } while ($dispatch = mysqli_fetch_array($dispatches)); ?>
            </table>
            <?php } else { ?>
            	<h2 align="center">NO TECH DISPATCHES</h2>
            <?php } ?>
            </div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
