<?php include("scripts/collapse.js");

$qry = "SELECT * FROM daily_message";
$dailys = mysqli_query($connection, $qry) or die (mysqli_error()); 
$daily = mysqli_fetch_array($dailys);
?>


<style>
body {
	background-image: url(images/0metal.jpg);
}
</style>
<script language="javascript">
function update_daily(val)
  {
	  	$.ajax
		({
			type: "POST",
			url: "ajax/update_daily_message.php",
			data: {message : val},
			success: function(result)
			{
				$("#dailyupdate").html("<font color='green'><b>Daily Message Updated</b></font>");
			}
		});
		
  }
</script>
</head>

<body>
<p>&nbsp;</p>

<div align="center">
<table width="680" border="0" cellpadding="0" cellspacing="0" id="cmsborder" align="center">
  <!--DWLayoutTable-->
  <tr>
    <td height="54" valign="top" align="center"><table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
      <!--DWLayoutTable-->
      <tr>

          <td width="680" valign="top" align="center"><table width="91%" border="0" cellpadding="0" cellspacing="0" align="center">
            <!--DWLayoutTable-->
            <tr>
				<td><img src="images/logo.gif" style="width:400px; height:auto;"/></td>
			</tr>
			<tr>
              <td width="100%" height="23" valign="top" id="head1_sp1"><!--DWLayoutEmptyCell-->&nbsp;</td>
              </tr>
            <tr>
              <td height="27" valign="top" id="topright_sp1">
				<table width="712">
					<tr>
						<td width="50%">
						<?php if ($_SESSION["name"]) { ?>
		                  <strong>Welcome - <?php echo $_SESSION["name"]; ?></strong>
						<?php } else { ?>
							&nbsp;
						<?php } ?>
						</td>
						<td align="right"><a href="main.php?logout=1">logout</a></td>
					</tr>
				</table>
				</td>
			
            </tr>
			<tr>
				<td>
				

				</td>
			</tr>
			<tr> 
			  <td class="text" align="center"> <br />
			    Click on each section header or +/- to toggle the selection for updating.
			      <br />
			      <br />
				  <br />
			      <table border="1" frame="border" width="80%" bgcolor="WHITE">
					<tr> 
				  		<td align="center"> 
				  			<table align="center" valign width="100%" border="0" frame="border">
                            <?php if ($_SESSION["userlevel"] > 1) { ?>
								<tr class="header">
	                    			<td width="78%"><a name="testexpand" onClick="expandcontent('garage')" style="cursor:hand; cursor:pointer">Dispatch</a></td>
                      				<td width="22%" align="right"><a name="testexpand" onClick="expandcontent('garage')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr> 
								<tr> 
                      				<td> 
										<div id="garage" class="switchcontent">
	                      				<table width="100%">
											<tr>
												<td><a href="archived_dispatches.php" title="View Closed Dispatches" target="_blank">Closed Dispatches</a></td>
											</tr>
                                            <tr>
												<td><a href="rejected_dispatches.php" title="View Cancelled Dispatches" target="_blank">Rejected Dispatches</a></td>
											</tr>
											
										</table>
										</div>
									</td>
								</tr>
                              <?php } ?>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
                                <tr class="header">
	                    			<td width="78%"><a name="testexpand" onClick="expandcontent('zencart')" style="cursor:hand; cursor:pointer">Additional Forms</a></td>
                      				<td width="22%" align="right"><a name="testexpand" onClick="expandcontent('zencart')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr> 
								<tr> 
                      				<td> 
										<div id="zencart" class="switchcontent">
	                      				<table width="100%">
											<tr>
												<td><a href="purchase_orders.php" title="Purchase Orders" target="_blank">Purchase Orders</a></td>
											</tr>
											<tr>
												<td><a href="customer_form.php" title="Customer Add Form" target="_blank">Customers</a></td>
											</tr>
										</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
								<tr class="header">
	                    			<td width="78%"><a name="testexpand" onClick="expandcontent('ads')" style="cursor:hand; cursor:pointer">Administrative</a></td>
                      				<td width="22%" align="right"><a name="testexpand" onClick="expandcontent('ads')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr> 
								<tr> 
                      				<td> 
										<div id="ads" class="switchcontent">
	                      				<table width="100%">
											<tr>
												<td><a href="dropdown_admin.php" title="Drop Down Fields" target="_blank">Drop Down Data</a></td>
											</tr>
                                             <?php if ($_SESSION["userlevel"] > 2) { ?>
											<tr>
												<td><a href="reports.php" title="View Reports" target="_blank">Reports</a></td>
											</tr>
                                            <?php } ?>
										</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
										
								<?php if ($_SESSION["userlevel"] > 2) { ?>
								<tr class="header">
	                    			<td><a name="testexpand" onClick="expandcontent('reporting')" style="cursor:hand; cursor:pointer">Users</a></td>
                      				<td align="right"><a name="testexpand" onClick="expandcontent('reporting')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr>
								<tr>
                      				<td>
										<div id="reporting" class="switchcontent">
                          				<table>
                         					<tr>
												<td><a href="admin_add_user.php" title="Add User" rel="gb_page_center[800, 450]">Add Admin/User</a></td>
											</tr>
											<tr>
												<td><a href="admin_view_user.php" title="View Users" rel="gb_page_center[750, 450]">View Users</a></td>
											</tr>
										</table>
                      					</div>
									</td>
								</tr>
								<?php } ?>
	         				</table>
						</td>
					</tr>
                    <?php if ($_SESSION["userlevel"] > 2) { ?>
                    <tr>
                    	<td><strong>Daily Message</strong></td>
                    </tr>
                    <tr>
                    	<td><div id="dailyupdate"></div><textarea id="daily_message" rows="3" cols="60" onChange="update_daily(this.value);"><?php echo $daily["message"]; ?></textarea>&nbsp;<input type="button" value="Update"></td>
                    </tr>
                    <?php } ?>
		 		 </table>
			</td>
			</tr>
            
          </table></td>
        </tr>
      
      
      
    </table></td>
  </tr>
</table>
</div>
