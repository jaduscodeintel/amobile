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

if ($_REQUEST["userid"])
{
	$userid = $_REQUEST["userid"];
}
if ($_POST["userid"])
{
	$userid = $_POST["userid"];
}


if ($_POST["adduserinfo"]) 
{
	
	
		
	if (!$_POST["fullname"])
	{
		$msg .= "<font color='red'>Please enter full name!</font><br>";
		$err = 1;
	}
	if (!$_POST["email"])
	{
		$msg .= "<font color='red'>Please enter an email!</font><br>";
		$err = 1;
	}
	if (!$_POST["level"])
	{
		$msg .= "<font color='red'>Please choose a user level!</font><br>";
		$err = 1;
	}
	
	if (!$err)
	{
		unset($_POST["adduserinfo"]);
		$where = "id = ".$_POST["userid"];
		unset($_POST["userid"]);
		modify_record("user", $_POST, $where);
		$msg = "<font color='green'>User Updated</font><br>";
		unset($_POST);?>
		<script language="javascript">
		location.href = "admin_view_user.php?id=<?php echo $userid; ?>";
		</script>
	<?php }
}


$qry = "SELECT user.* FROM user WHERE id = ".$_REQUEST["userid"]." ORDER BY level";
$users = mysql_query($qry) or die('Query failed: ' . mysql_error()); 
$user = mysql_fetch_assoc($users);

$_POST = $user;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
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

<form action="admin_edit_user.php" enctype="multipart/form-data" method="post" name="adduser">
<input type="hidden" name="adduserinfo" value="1">
<input type="hidden" name="userid" value="<?php echo $userid; ?>">
<table width="100%" frame="box" border="0">
	<tr>
		<td ><img src="images/goldpanner.png" width="250" /></td>
	  	<td width="458" align="right" valign="bottom"><h3>Edit User</h3></td>
	</tr>
	<tr>
		<td colspan="2"><hr /></td>
	</tr>
</table>
<table width="100%" frame="box" border="0">
	<?php if ($msg) { ?>
	<tr>
		<td>&nbsp;</td>
		<td><font size="1"><?php echo $msg; ?></font></td>
	</tr>
	<?php } ?>
	<tr>
		<td align="right"><strong>User Name:</strong></td>
		<td><input type="text" name="username" value="<?php echo $_POST["username"]; ?>" disabled="disabled"/></td>
	</tr>
	<tr>
		<td align="right"><strong>Password:</strong></td>
		<td>***********&nbsp;&nbsp;&nbsp;<a href="admin_change_password.php?id=<?php echo $_POST["id"]; ?>" title="Change Password" rel="gb_page_center[500, 350]">change password</a></td>
	</tr>
	<tr>
		<td align="right"><strong>Full Name:</strong></td>
		<td><input type="text" name="fullname" value="<?php echo $_POST["fullname"]; ?>" /></td>
	</tr>
	<tr>
		<td align="right"><strong>Email:</strong></td>
		<td><input type="text" name="email" value="<?php echo $_POST["email"]; ?>" /></td>
	</tr>
	<tr>
		<td align="right"><strong>Level:</strong></td>
		<td>
		<select name="level">
			<option value="0">Select One...</option>
			<option value="1" <?php if ($_POST["level"] == 1) { ?>selected<?php } ?>>Level 1 - Basic Admin</option>
			<option value="2" <?php if ($_POST["level"] == 2) { ?>selected<?php } ?>>Level 2 - Super Admin</option>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Update User" /></td>
	</tr>
</table>
</form>
<hr />
</body>
</html>
