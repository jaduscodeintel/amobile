<?php 
require_once('../db/DB.php');
include('../db/tablefuncs.php');
mysql_select_db($database_DB, $ravcodb);
session_start();
if ($_REQUEST["logout"])
{
	unset($_SESSION["loginid"]);
	unset($_SESSION["userlevel"]);
	unset($_SESSION["username"]);
}

if (!$_SESSION["loginid"] )
{
	header("location: login.php");
}

?>
<?php include("../scripts/collapse.js"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gold Panner Administrative</title>
<link href="../includes/cms.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    var GB_ROOT_DIR = "../scripts/";
</script>


<script type="text/javascript" src="../scripts/AJS.js"></script>
<script type="text/javascript" src="../scripts/AJS_fx.js"></script>
<script type="text/javascript" src="../scripts/gb_scripts.js"></script>
<link href="../scripts/gb_styles.css" rel="stylesheet" type="text/css" />
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
				<td><img src="images/header.jpg" /></td>
			</tr>
			<tr>
              <td width="100%" height="23" valign="top" id="head1_sp1"><!--DWLayoutEmptyCell-->&nbsp;</td>
              </tr>
            <tr>
              <td height="27" valign="top" id="topright_sp1"><span class="header1_text">&nbsp;goldpanner.com - CONTENT MANAGEMENT</span><br />
                <br />
				<table width="712">
					<tr>
						<td width="50%">
						<?php if ($_SESSION["username"]) { ?>
		                  <strong>Welcome - <?php echo $_SESSION["username"]; ?></strong>
						<?php } else { ?>
							&nbsp;
						<?php } ?>
						</td>
						<td align="right"><a href="admin.php?logout=1">logout</a></td>
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
			      <table border="1" frame="border" width="80%" bgcolor="#E8E8E8">
					<tr> 
				  		<td align="center"> 
				  			<table align="center" valign width="100%" border="0" frame="border">
								<tr class="header">
	                    			<td width="78%"><a name="testexpand" onclick="expandcontent('garage')" style="cursor:hand; cursor:pointer">Garage Sales</a></td>
                      				<td width="22%" align="right"><a name="testexpand" onclick="expandcontent('garage')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr> 
								<tr> 
                      				<td> 
										<div id="garage" class="switchcontent">
	                      				<table width="100%">
											<tr>
												<td><a href="admin_garage_sales.php" title="Add and View Garage Sales" rel="gb_page_center[800, 750]">Garage Sales</a></td>
											</tr>
											
										</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
                                <tr class="header">
	                    			<td width="78%"><a name="testexpand" onclick="expandcontent('zencart')" style="cursor:hand; cursor:pointer">Zencart Orders</a></td>
                      				<td width="22%" align="right"><a name="testexpand" onclick="expandcontent('zencart')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr> 
								<tr> 
                      				<td> 
										<div id="zencart" class="switchcontent">
	                      				<table width="100%">
											<tr>
												<td><a href="admin_zencart_orders.php" title="Zencart Orders" rel="gb_page_center[1200, 850]">Zencart Orders</a></td>
											</tr>
										</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
								<tr class="header">
	                    			<td width="78%"><a name="testexpand" onclick="expandcontent('ads')" style="cursor:hand; cursor:pointer">Weekly Ads</a></td>
                      				<td width="22%" align="right"><a name="testexpand" onclick="expandcontent('ads')" style="cursor:hand; cursor:pointer">+|- more</a></td>
                    			</tr> 
								<tr> 
                      				<td> 
										<div id="ads" class="switchcontent">
	                      				<table width="100%">
											<tr>
												<td><a href="admin_add_weekly_ads.php" title="Add Weekly Ads" rel="gb_page_center[800, 750]">Weekly Ads</a></td>
											</tr>
											<tr>
												<td><a href="admin_view_weekly_ads.php" title="View Weekly Ads" rel="gb_page_center[800, 750]">View Weekly Ads</a></td>
											</tr>
										</table>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
										
								<?php if ($_SESSION["userlevel"] > 1) { ?>
								<tr class="header">
	                    			<td><a name="testexpand" onclick="expandcontent('reporting')" style="cursor:hand; cursor:pointer">Users</a></td>
                      				<td align="right"><a name="testexpand" onclick="expandcontent('reporting')" style="cursor:hand; cursor:pointer">+|- more</a></td>
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
		 		 </table>
			</td>
			</tr>
            
          </table></td>
        </tr>
      
      
      
    </table></td>
  </tr>
</table>
</div>
</body>
</html>
