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

if ($_REQUEST["delid"])
{
	delete_record_secondary("user", $_REQUEST["delid"], "id");
}


$qry = "SELECT user.* FROM user ORDER BY level DESC";
$users = mysql_query($qry) or die('Query failed: ' . mysql_error()); 
$user = mysql_fetch_assoc($users);
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
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

<form action="admin_add_user.php" enctype="multipart/form-data" method="post" name="adduser">
<input type="hidden" name="adduserinfo" value="1">
<table border="0" cellpadding="0" cellspacing="0" width="96%">
	<tr>
		<td colspan="3"><img src="images/goldpanner.png" width="250" /></td>
	  <td width="458" align="right" valign="bottom"><h3>View Users</h3></td>
	</tr>
	<tr>
		<td colspan="4"><hr /></td>
	</tr>
</table>
<table width="96%" frame="box" border="0">
	<tr bgcolor="#D8D7E3">
		<td><strong>User Name</strong></td>
		<td><strong>Password</strong></td>
		<td><strong>Name</strong></td>
		<td><strong>Email</strong></td>
		<td><strong>Level</strong></td>
		<td><strong>Action</strong></td>
	</tr>
	<?php 
	$bgcolor = "WHITE";
	do { 
	if ($_REQUEST["id"] == $user["id"])
	{
		$bgcolor = "#FF6666";
	} else {
		$bgcolor = "white";
	}
	?>
	<tr bgcolor="<?php echo $bgcolor; ?>">
		<td><?php echo $user["username"]; ?></td>
		<td><?php echo $user["password"]; ?></td>
		<td><?php echo $user["fullname"]; ?></td>
		<td><?php echo $user["email"]; ?></td>
		<td><?php echo $user["level"]; ?></td>
		<td><a href="admin_edit_user.php?userid=<?php echo $user["id"]; ?>" title="Edit User" rel="gb_page_center[550, 500]">edit</a>&nbsp;&nbsp; <a href="admin_view_user.php?delid=<?php echo $user["id"]; ?>" onClick="javascript:return confirm('Are you sure you want to delete this user?')">delete</a></td>
	</tr>
	<?php 
	if ($bgcolor == "WHITE")
	{
		$bgcolor = "#D8D8D8";
	} else {
		$bgcolor = "WHITE";
	}
	} while ($user = mysql_fetch_assoc($users)); ?>
</table>
</form>

</body>
</html>
