<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');

$require = 1;

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
  <script src="js/jquery.tablesorter.min.js"></script>

  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  
  $(document).ready(function() 
    { 
        $("#archivetable").tablesorter(); 
    } 
  ); 

  function tabs1_click()
  {
	  	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_closed_dispatches.php",
			success: function(result)
			{
				if (result) 
				{ 
					$( "#tabs" ).tabs( "option", "active", 0 );
					$("#tabs-1").html(result);
				}
			}
		});
		
  }
  
  function tabs2_click(did)
  {
	  	$.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_get_dispatch_form.php",
			data: {id : did},
			success: function(result)
			{
				if (result) 
				{ 
					$( "#tabs" ).tabs( "option", "active", 1 );
					$("#tabs-2").html(result);
				}
			}
		});
		
  }
  
  function reopen_dispatch(did)
  {
	  $.ajax
		({
			type: "POST",
			url: "ajax/update_open_dispatch.php",
			data: {id : did},
			success: function(result)
			{
				if (result) 
				{ 
					//alert(result);
					add_timestamp(did, 0, 'Open Dispatch', 0);
					tabs1_click();
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
  
  function search_archives()
  {
	  
	  field = $("#searchdrop").val();
	  val = $("#searchfield").val();
	  
	  $.ajax
		({
			type: "POST",
			url: "ajax_admin/admin_closed_dispatches.php",
			data: {searchfield : field, searchval : val},
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
<style>
body {
	background-image: url(images/0metal.jpg);
}

th.tablesorter-headerAsc { 
    background-image: url(images/black-asc.gif); 
	background-repeat: no-repeat; 
    background-color: #3399FF; 
} 

th.tablesorter-headerDesc { 
    background-image: url(images/black-desc.gif); 
	background-repeat: no-repeat; 
    background-color: #3399FF; 
} 

th.tablesorter-headerUnSorted { 
    background-image: url(images/black-unsorted.gif); 
    cursor: pointer; 
    font-weight: bold; 
    background-repeat: no-repeat; 
    background-position: center left; 
    padding-left: 20px; 
    border-right: 2px solid #dad9c7; 
    margin-left: -1px; 
	background-color: #66b3ff;
} 
</style>
</head>

<body>
<p>&nbsp;</p>

<div align="center">
<table width="1300" border="0" cellpadding="0" cellspacing="0" id="cmsborder2" align="center">
	<tr>
    	<td><h1 style="margin-left:20px;">Archived Dispatches</h1></td>
    </tr>
    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid GREEN;" >
               <div id="tabs">
                  <ul>
                  	<li><a href="#tabs-1">Closed Dispatches</a></li>
                    <li><a href="#tabs-2">View Dispatch Details</a></li>
                   
                  </ul>
                  <div id="tabs-1">
                   	<?php include("ajax_admin/admin_closed_dispatches.php"); ?>
                  </div>
                  <div id="tabs-2">
                   	<?php include("closed_dispatch_form.php"); ?>
                  </div>
                </div>
 			</div>
        </td>
    </tr>
</table>
</div>
</body>
</html>