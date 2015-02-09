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
  <link rel="stylesheet" href="js/datepicker/jquery-ui.css">
  <script src="js/datepicker/jquery-ui.js"></script>

  <script>
  
  $(document).ready(function() 
  { 
        $("#archivetable").tablesorter(); 
		
		$(function() {
			$( "#startdate" ).datepicker();
	  	});
		
		$(function() {
			$( "#enddate" ).datepicker();
	  	});
		
		$( "#startdate" ).datepicker({
  			dateFormat: "yy-mm-dd"
		});
		
		$( "#enddate" ).datepicker({
  			dateFormat: "yy-mm-dd"
		});
		
   }); 
  
  function get_report()
  {
	  searchtype = $("#searchtype").val();
	  datetype = $("#datetype").val();
	  startdate = $("#startdate").val();
	  enddate = $("#enddate").val();
	  
	  if (startdate == "start date")
	  {
		  startdate = "";
	  }
	  if (enddate == "end date")
	  {
		  enddate = "";
	  }
	  
	  $.ajax
	({
		type: "POST",
		url: "ajax_admin/admin_get_reports.php",
		data: {stype : searchtype, dtype : datetype, sdate : startdate, edate : enddate},
		success: function(result)
		{
			if (result) 
			{ 
				$("#resultsdiv").html(result);
				
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
    	<td><h1 style="margin-left:20px;">Reports</h1></td>
    </tr>
    <tr>
    	<td style="padding:5px;">
        	<div style="border:1px solid GREEN;" >
             	<div id="searchdiv" style="margin:10px;">
                <select name="searchtype" id="searchtype">
                	<option value="Calls per Customer">Calls per Customer</option>
                    <option value="Calls per Month">Calls per Month</option>
                    <option value="Calls per State">Calls per State</option>
                    <option value="Calls per Tech">Calls per Tech</option>
                    <option value="Calls per Dispatcher">Calls per Dispatcher</option>
                </select>&nbsp;&nbsp;&nbsp;
                <select name="datetype" id="datetype">
                	<option value="This Month">This Month</option>
                    <option value="Last Month">Last Month</option>
                    <option value="Last 6 Months">Last 6 Months</option>
                    <option value="This Year">This Year</option>
                </select>&nbsp;&nbsp;&nbsp; - OR - &nbsp;&nbsp;&nbsp;
                <input type="text" value="start date" id="startdate" size="20" onclick="this.value=''"/>&nbsp;&nbsp;<input type="text" value="end date" id="enddate" size="20" onclick="this.value=''"/>&nbsp;&nbsp;
                <input type="button" value="Submit" onclick="get_report()" />
                </div>
                <div id="resultsdiv" style="margin:10px;"></div>
 			</div>
        </td>
    </tr>
</table>
</div>
</body>
</html>