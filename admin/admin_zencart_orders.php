<?php 
require_once('../db/DB2.php');
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



if ($_POST["addgarage"])
{
	unset($_POST["addgarage"]);
	$newid = add_record("garagesales", $_POST);
}	

$qry = "SELECT orders.* FROM orders ORDER BY date_purchased DESC LIMIT 100";
$orders = mysql_query($qry) or die('Query failed: ' . mysql_error()); 
$order = mysql_fetch_assoc($orders);
	

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
	  <td width="458" align="right" valign="bottom"><h3>Zencart Orders</h3></td>
	</tr>
	<tr>
		<td colspan="4"><hr /></td>
	</tr>
</table>

<table width="96%" frame="box" border="0">
	<tr bgcolor="#D8D7E3">
		<td><strong>Customer Name</strong></td>
		<td><strong>Customer Number</strong></td>
        <td><strong>Payment</strong></td>
        <td><strong>Ad Info</strong></td>
        <td><strong>Invoice Number</strong></td>
        <td><strong>Date</strong></td>
	</tr>
	<?php 
	$bgcolor = "WHITE";
	if ($order["orders_id"])
	{
		do { 
		
		?>
			<tr bgcolor="<?php echo $bgcolor; ?>">
				<td><?php echo $order["customers_name"]; ?></td>
				<td><?php echo $order["customers_telephone"]; ?></td>
				<td><?php echo $order["order_total"]; ?></td>
                <td><?php echo "Unknown"; ?></td>
                <td><?php echo $order["orders_id"]; ?></td>
                <td><?php echo $order["date_purchased"]; ?></td>
			</tr>
		<?php 
		if ($bgcolor == "WHITE")
		{
			$bgcolor = "#D8D8D8";
		} else {
			$bgcolor = "WHITE";
		}
		} while ($order = mysql_fetch_assoc($orders)); ?>
	<?php } else { ?>
		<tr>
			<td><h2>No Orders Yet</h2></td>
		</tr>
	<?php } ?>
	</table>


</body>
</html>
