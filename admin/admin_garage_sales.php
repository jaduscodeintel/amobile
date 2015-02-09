<?php 
require_once('../db/DB.php');
include('../db/tablefuncs.php');
mysql_select_db($database_DB, $ravcodb);
session_start();
if (!$_SESSION["loginid"] || $_SESSION["userlevel"] < 2)
{?>
<script language="javascript">
parent.parent.location.href='admin.php';
window.close();
</script>
<?php }

if ($_POST["deleteall"])
{
	$qry = "Delete FROM garagesales";
	mysql_query($qry);
	echo "ALL DELETED!";
}

if ($_REQUEST["delid"])
{
	delete_record_secondary("garagesales", $_REQUEST["delid"], "id");
}

if ($_POST["addgarage"])
{
	unset($_POST["addgarage"]);
	$newid = add_record("garagesales", $_POST);
}	

$qry = "SELECT garagesales.* FROM garagesales ORDER BY date, id";
$ids = mysql_query($qry) or die('Query failed: ' . mysql_error()); 
$id = mysql_fetch_assoc($ids);
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Garage Sales</title>
<link href="../includes/cms.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../calendar/calendar-win2k-1.css" title="win2k-1" />


<!-- main calendar program -->
<script type="text/javascript" src="../calendar/calendar.js"></script>

<!-- language for the calendar -->
<script type="text/javascript" src="../calendar/lang/calendar-en.js"></script>

<!-- the following script defines the Calendar.setup helper function, which makes
     adding a calendar a matter of 1 or 2 lines of code. -->
<script type="text/javascript" src="../calendar/calendar-setup.js"></script>

<script type="text/javascript">
    var GB_ROOT_DIR = "greybox/";
</script>


<script type="text/javascript" src="greybox/AJS.js"></script>
<script type="text/javascript" src="greybox/AJS_fx.js"></script>
<script type="text/javascript" src="greybox/gb_scripts.js"></script>
<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" />

<script language="javascript">
function reloadIt()
{
	window.location = "admin_view_user.php";
}
</script>
</head>

<body>


<table border="0" cellpadding="0" cellspacing="0" width="96%">
	<tr>
		<td colspan="3"><img src="images/goldpanner.png" width="250" /></td>
	  <td width="458" align="right" valign="bottom"><h3>View and Add Garage Sales</h3></td>
	</tr>
	<tr>
		<td colspan="4"><hr /></td>
	</tr>
</table>
<form method="post" action="admin_garage_sales.php">
<input type="hidden" name="addgarage" value="1" />
<table width="96%" frame="box" border="0">
	<tr>
		<td><strong>Add New Garage Sale Address:</strong></td>
		<td align="left"><input type="text" id="address" name="address" size="50"/></td>
	</tr>
	<tr>
		<td><strong>Garage Sale text:</strong></td>
		<td align="left"><textarea name="garagetext" id="garagetext" cols="39" rows="3"></textarea></td>
	</tr>
	<tr>
		<td><input type="hidden" name="date" id="date" value="<?php echo date("Y/m/d"); ?>" /><input type="submit" value="Add Address" /></td>
		<td align="right"><input type="button" onClick="if (confirm('Are you sure you want to delete this weeks garage sales?')) document.deleteall.submit(); return false" value="delete all" style="background-color:red; color:white;"/></td>
	</tr>
</table>
</form>
<table width="96%" frame="box" border="0">
	<tr bgcolor="#D8D7E3">
		<td><strong>Date</strong></td>
		<td><strong>Address</strong></td>
		<td><strong>Action</strong></td>
	</tr>
	<?php 
	$bgcolor = "WHITE";
	if ($id["id"])
	{
		do { 
		if ($newid == $id["id"])
		{
			$bgcolor = "#FF6666";
		} 
		?>
			<tr bgcolor="<?php echo $bgcolor; ?>">
				<td><?php echo $id["date"]; ?></td>
				<td><?php echo $id["address"]; ?></td>
				<td align="center"><a href="admin_garage_sales.php?delid=<?php echo $id["id"]; ?>" onClick="javascript:return confirm('Are you sure you want to delete this Address?')">delete</a></td>
			</tr>
		<?php 
		if ($bgcolor == "WHITE")
		{
			$bgcolor = "#D8D8D8";
		} else {
			$bgcolor = "WHITE";
		}
		} while ($id = mysql_fetch_assoc($ids)); ?>
	<?php } else { ?>
		<tr>
			<td><h2>No Garage Sales Yet</h2></td>
		</tr>
	<?php } ?>
	</table>
	<form method="post" action="admin_garage_sales.php" id=" deleteall" name="deleteall">
	<input type="hidden" name="deleteall" value="1" />
	</form>


</body>
</html>
