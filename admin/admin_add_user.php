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

if ($_POST["adduserinfo"]) 
{
	
	if ($_POST["username"])
	{
		$qry = "SELECT * FROM user WHERE username ='".$_POST["username"]."'";
		$users = mysql_query($qry) or die('Query failed: ' . mysql_error()); 
		$user = mysql_fetch_assoc($users);
		
		if ($user)
		{
			$msg = "<font color='red'>User name already chosen!</font><br>";
			$err = 1;
		}
	}
		
	if (!$_POST["username"])
	{
		$msg .= "<font color='red'>Please choose a user name!</font><br>";
		$err = 1;
	}
	if (!$_POST["password"])
	{
		$msg .= "<font color='red'>Please enter a password!</font><br>";
		$err = 1;
	}
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
	$_POST["password"] = md5($_POST["password"]);
	if (!$err)
	{
		unset($_POST["adduserinfo"]);
		$id = add_record("user", $_POST);
		$msg = "<font color='green'>New User Added</font><br>";
		unset($_POST); ?>
		<script language="javascript">
		location.href = "admin_view_user.php?id=<?php echo $id; ?>";
		</script>
<?php	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../includes/cms.css" rel="stylesheet" type="text/css" />

</head>

<body>

<form action="admin_add_user.php" enctype="multipart/form-data" method="post" name="adduser">
<input type="hidden" name="adduserinfo" value="1">
<table width="100%" frame="box" border="0">
	<tr>
		<td ><img src="images/goldpanner.png" width="250"/></td>
	  	<td width="458" align="right" valign="bottom"><h3>Add User</h3></td>
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
		<td><input type="text" name="username" value="<?php echo $_POST["username"]; ?>"/></td>
	</tr>
	<tr>
		<td align="right"><strong>Password:</strong></td>
		<td><input type="password" name="password" value="<?php echo $_POST["password"]; ?>" /></td>
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
		<td><input type="submit" value="Add New User" /></td>
	</tr>
</table>
</form>
<hr />
</body>
</html>
