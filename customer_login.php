<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');
include('db/tablefuncs.php');

if ($_POST["attempt"])
{
	$qry = "SELECT users_customers.*
	 WHERE users_customers.username = '".$_POST["username"]."' AND users_customers.password = '".md5($_POST["password"])."' AND users.disabled = 0";
	 
	//echo $qry;
	
	$logins = mysqli_query($connection, $qry); 

	$login = mysqli_fetch_array($logins);
	
	if ($login)
	{
		
			$_SESSION["cloginid"] = $login["id"];
			$_SESSION["cid"] = $login["cid"];
			header("location: customer_dispatch_form.php");
	} else {
		$errormsg = "<font color='red'>Sorry, That username/password combination<BR>is invalid, please try again</font>";
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
						<form name="loginform" method="post" action="login.php">
						<input type="hidden" name="attempt" id="attempt" value="1" />
						<table align="center" valign width="100%" border="0" frame="border">
							<tr>
								<td colspan="2" align="center"><strong>Please Log In</strong></td>
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
								<td align="right"><strong>User Name: </strong></td>
								<td><input type="text" name="username" id="username"/></td>
							</tr>
							<tr>
								<td align="right"><strong>Password: </strong></td>
								<td><input type="password" name="password" id="password"/></td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="center"><input type="submit" value="Login to CMS" /></td>
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
