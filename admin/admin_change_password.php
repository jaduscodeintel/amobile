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

if ($_REQUEST["id"])
{
	$userid = $_REQUEST["id"];
}
if ($_POST["id"])
{
	$userid = $_POST["id"];
}


if ($_POST["adduserinfo"]) 
{
	
	
		
	if (!$_POST["password"])
	{
		$msg .= "<font color='red'>Please enter a new password, or close the window!</font><br>";
		$err = 1;
	}
	
	if (!$err)
	{
		$_POST["password"] = md5($_POST["password"]);
		unset($_POST["adduserinfo"]);
		$where = "id = ".$userid;
		unset($_POST["userid"]);
		modify_record("user", $_POST, $where);
		$msg = "<font color='green'>User Updated</font><br>";
		unset($_POST);?>
		<script language="javascript">
		parent.parent.location.href = "admin_view_user.php?id=<?php echo $userid; ?>";
		window.close();
		</script>
	<?php }
}


$qry = "SELECT user.* FROM user WHERE id = ".$userid." ORDER BY level";
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

<form action="admin_change_password.php" enctype="multipart/form-data" method="post" name="adduser">
<input type="hidden" name="adduserinfo" value="1">
<input type="hidden" name="id" value="<?php echo $userid; ?>">
<table width="100%" frame="box" border="0">
	<tr>
		<td ><img src="images/goldpanner.png" width="250" /></td>
	  	<td width="458" align="right" valign="bottom"><h3>Edit Password</h3></td>
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
		<td align="right"><strong>New Password:</strong></td>
		<td><input type="text" name="password" value="" /></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Update Password" /></td>
	</tr>
</table>
</form>
<hr />
</body>
</html>
