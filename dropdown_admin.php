<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');
include('db/tablefuncs.php');

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <title>Amobile Maintenance Dispatch Application</title>
  <link href="includes/cms.css" rel="stylesheet" type="text/css" />
  <link href="scripts/gb_styles.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="js/ui/jquery-ui.css">
  <script src="js/jquery-1.11.1.js"></script>
  <script src="js/ui/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  
  function tabs2_click(did)
  {
	  	$.ajax
		({
			type: "POST",
			url: "ajax/get_dispatch_form.php",
			data: {id : did},
			success: function(result)
			{
				if (result) 
				{ 
					$( "#tabs" ).tabs( "option", "active", 0 );
					$("#dispatch_form").html(result);
				}
			}
		});
		
  }

  </script>
<style>
body {
	background-image: url(images/0metal.jpg);
}
</style>
</head>

<body>
<p>&nbsp;</p>

<div align="center">
<table width="1300" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">
	<tr>
    	<td><h1 style="margin-left:20px;">Drop Down Control Panel</h1></td>
    </tr>
    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid GREEN;" >
               <div id="tabs">
                  <ul>
                  	<li><a href="#tabs-1">Techs</a></li>
                    <li><a href="#tabs-2">Dispatchers</a></li>
                    <li><a href="#tabs-3">Tech Status</a></li>
                    <li><a href="#tabs-4">Problems</a></li>
                    <li><a href="#tabs-5">ETAS</a></li>
                    <li><a href="#tabs-6">Referrals</a></li>
                    <li><a href="#tabs-7">Shifts</a></li>
                    <li><a href="#tabs-8">States</a></li>
                    <li><a href="#tabs-9">Rejected Reasons</a></li>
                    <li><a href="#tabs-10">Tire Positions</a></li>
                    <li><a href="#tabs-11">Tire Codes</a></li>
                    <li><a href="#tabs-12">Tire Sizes</a></li>
                    <li><a href="#tabs-13">Tire Storage</a></li>
                  </ul>
                  <div id="tabs-1">
                   	<?php include("ajax_admin/admin_techs.php"); ?>
                  </div>
                  <div id="tabs-2">
                   	<?php include("ajax_admin/admin_dispatchers.php"); ?>
                  </div>
                  <div id="tabs-3">
                   	<?php include("ajax_admin/admin_tech_status.php"); ?>
                  </div>
                  <div id="tabs-4">
                   	<?php include("ajax_admin/admin_problems.php"); ?>
                  </div>
                  <div id="tabs-5">
                   	<?php include("ajax_admin/admin_etas.php"); ?>
                  </div>
                  <div id="tabs-6">
                   	<?php include("ajax_admin/admin_referrals.php"); ?>
                  </div>
                  <div id="tabs-7">
                   	<?php include("ajax_admin/admin_shifts.php"); ?>
                  </div>
                  <div id="tabs-8">
                   	<?php include("ajax_admin/admin_states.php"); ?>
                  </div>
                  <div id="tabs-9">
                   	<?php include("ajax_admin/admin_reject_reasons.php"); ?>
                  </div>
                  <div id="tabs-10">
                   	<?php include("ajax_admin/admin_tire_positions.php"); ?>
                  </div>
                  <div id="tabs-11">
                   	<?php include("ajax_admin/admin_tire_codes.php"); ?>
                  </div>
                  <div id="tabs-12">
                   	<?php include("ajax_admin/admin_tire_sizes.php"); ?>
                  </div>
                  <div id="tabs-13">
                   	<?php include("ajax_admin/admin_tire_locations.php"); ?>
                  </div>
                </div>
 			</div>
        </td>
    </tr>
</table>
</div>
</body>
</html>