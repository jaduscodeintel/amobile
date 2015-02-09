<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');
include('db/tablefuncs.php');

if ($_POST["attempt"])
{
	if ($_POST["password"] == $_POST["password2"])
	{
		$password = md5($_POST["password"]);
		$qry = "UPDATE users SET password = '".$password."', password_change = 0 WHERE id = ".$_SESSION["cpid"];
		//echo $qry;
		mysqli_query($connection, $qry);
		$_SESSION["loginid"] = $_SESSION["cpid"];
		header("location: main.php");
	} else {
		$errormsg = "<font color='red'>Sorry, the passwords did not match<BR>please try again</font>";
	}
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login Page</title>
</head>

<body>
<center>
<table width="100%" height="100%" border="0">
	<tr>
		<td valign="middle" align="center">
			<table border="1" frame="border" width="35%" bgcolor="#E9E9E9">
				<tr>
					<td>
						<form name="loginform" method="post" action="change_password.php">
						<input type="hidden" name="attempt" id="attempt" value="1" />
						<table align="center" valign width="100%" border="0" frame="border">
							<tr>
								<td colspan="2" align="center"><strong>Please Change Your Password</strong></td>
							</tr>
							<?php if ($errormsg) { ?>
							<tr>
								<td colspan="2" align="center"><?php echo $errormsg; ?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><strong>Password: </strong></td>
								<td><input type="password" name="password" id="password"/></td>
							</tr>
							<tr>
								<td align="right"><strong>Again: </strong></td>
								<td><input type="password" name="password2" id="password2"/></td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><input type="submit" value="Change Password" /></td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</center>
</body>
</html>
