<?php 
error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');
include('db/tablefuncs.php');

if ($_POST["attempt"])
{
	$qry = "SELECT users.*, techs.id as tid, dispatchers.id as did FROM users
	 LEFT JOIN techs ON (users.id = techs.uid)
	 LEFT JOIN dispatchers ON (users.id = dispatchers.uid)
	 WHERE users.username = '".$_POST["username"]."' AND users.password = '".md5($_POST["password"])."' AND users.disabled = 0";
	 
	//echo $qry;
	
	$logins = mysqli_query($connection, $qry); 

	$login = mysqli_fetch_array($logins);
	
	if ($login)
	{
		if ($login["password_change"])
		{
			$_SESSION["cpid"] = $login["id"];
			$_SESSION["userlevel"] = $login["level"];
			$_SESSION["name"] = $login["name"];
			if ($login["tid"])
			{
				$_SESSION["tid"] = $login["tid"];
			}
			if ($login["did"])
			{
				$_SESSION["did"] = $login["did"];
			}
			header("location: change_password.php");
		} else {
			$_SESSION["loginid"] = $login["id"];
			$_SESSION["userlevel"] = $login["level"];
			$_SESSION["name"] = $login["name"];
			if ($login["tid"])
			{
				$_SESSION["tid"] = $login["tid"];
			}
			if ($login["did"])
			{
				$_SESSION["did"] = $login["did"];
			}
			header("location: main.php");
		}
		
	} else {
		$errormsg = "<font color='red'>Sorry, That username/password combination<BR>is invalid, please try again</font>";
	}
}

$qry = "SELECT * FROM daily_message";
$dailys = mysqli_query($connection, $qry) or die (mysqli_error()); 
$daily = mysqli_fetch_array($dailys)
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
                            <tr>
                            	<td colspan="2" align="center" style="color:red;"><strong>Daily Message: </strong><?php echo $daily["message"]; ?></td>
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
