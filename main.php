<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');
include('db/tablefuncs.php');

if ($_REQUEST["logout"])
{
	unset($_SESSION["loginid"]);
	unset($_SESSION["userlevel"]);
	unset($_SESSION["name"]);
	unset($_SESSION["cpid"]);
	unset($_SESSION["tid"]);
	unset($_SESSION["did"]);
			
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

	<!-- <script type="text/javascript">
        var GB_ROOT_DIR = "scripts/";
    </script>
    
    
    <script type="text/javascript" src="scripts/AJS.js"></script>
    <script type="text/javascript" src="scripts/AJS_fx.js"></script>
    <script type="text/javascript" src="scripts/gb_scripts.js"></script>
    <link href="scripts/gb_styles.css" rel="stylesheet" type="text/css" /> -->
    
    <link rel="stylesheet" href="js/ui/jquery-ui.css">
  	<script src="js/jquery-1.11.1.js"></script>
  	<script src="js/ui/jquery-ui.js"></script>
    
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css" media="screen" />
    <script type="text/javascript" src="fancybox/jquery.fancybox.pack.js"></script> 
	
  <script>
  
  jQuery( document ).ready(function( $ ) {
	  	fn180sec();
		setInterval(fn180sec, 180*1000);
  });
  
  function fn180sec() {
    tabs3_click();
	tabs4_click();
  }

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
  
  function tabs3_click()
  {
	  	$.ajax
		({
			type: "POST",
			url: "ajax/get_open_dispatches.php",
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
  
  function tabs4_click()
  {
	  	$.ajax
		({
			type: "POST",
			url: "ajax/get_tech_dispatches.php",
			success: function(result)
			{
				if (result) 
				{ 
					$("#tech_dispatches").html(result);
					
				}
			}
		});
		
  }
  
  function add_timestamp(did, uid, type, ssid)
  {
	  $.ajax
		({
			type: "POST",
			url: "ajax/add_timestamp.php",
			data: {id : did, user : uid, atype : type, sid : ssid},
			success: function(result)
			{
				if (result) 
				{ 
					//alert(result);
					if (result == "Success")
					{
						//alert(result);
					}
				}
			}
		});
  
  }


  </script>
</head>

<body>
<p>&nbsp;</p>

<div align="center">
<table width="1300" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">
	<tr>
    	<td><h1 style="margin-left:20px;">Dispatch Control Panel</h1></td>
    </tr>
    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid GREEN;" >
            
                <div id="tabs">
                  <ul>
                  	<?php if ($_SESSION["userlevel"] > 1) { ?>
                  	<li><a href="#tabs-1">Dispatch Form</a></li>
                    <li><a href="#tabs-2">Open Dispatches</a></li>
                    <?php } ?>
                    <li><a href="#tabs-3">Tech Dispatches</a></li>
                    <li><a href="#tabs-4">Tech Status</a></li>
                    <?php if ($_SESSION["userlevel"] > 1) { ?>
                    <li><a href="#tabs-5">Admin</a></li>
                    <?php } ?>
                  </ul>
                  <div id="tabs-1" <?php if ($_SESSION["userlevel"] < 2) { ?>style="display: none;"<?php } ?>>
                   	<?php include("dispatch_form.php"); ?>
                  </div>
                  <div id="tabs-2" <?php if ($_SESSION["userlevel"] < 2) { ?>style="display: none;"<?php } ?>>
                   	<?php include("open_dispatches.php"); ?>
                  </div>
                  <div id="tabs-3">
                   	<?php include("tech_dispatches.php"); ?>
                  </div>
                  <div id="tabs-4">
                   	<?php include("tech_status.php"); ?>
                  </div>
                  <div id="tabs-5" <?php if ($_SESSION["userlevel"] < 2) { ?>style="display: none;"<?php } ?>>
                   	<?php include("admin.php"); ?>
                  </div>
                </div>
 			</div>
        </td>
    </tr>
</table>
</div>
</body>
</html>