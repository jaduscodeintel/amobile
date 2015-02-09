<?php 

error_reporting(E_ALL & ~E_NOTICE);
require_once('db/DB.php');
include('db/tablefuncs.php');

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

if ($_POST)
{
	$qry = "UPDATE customers SET name = '".$_POST["name"]."', address = '".$_POST["address"]."', phone = '".$_POST["phone"]."', fax = '".$_POST["fax"]."', email = '".$_POST["email"]."', dispatch_notes = '".$_POST["dispatch_notes"]."' WHERE id = ".$_POST["cid"];
	echo $qry;
	mysqli_query($connection, $qry) or die (mysqli_error());
	header("location: customer_list.php");
} 

if ($_REQUEST["cid"])
{
	$qry = "SELECT * FROM customers WHERE id = ".$_REQUEST["cid"];
	$customers = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$customer = mysqli_fetch_array($customers);
} else {
	header("location: customer_list.php");
}




 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Amobile Maintenance Administrative</title>
<link href="includes/cms.css" rel="stylesheet" type="text/css" />

<style>
body {
	background-image: url(images/0metal.jpg);
}

#customer_form
{
	font-family:Verdana, Geneva, sans-serif;
	font-size: 9px;	
}
</style>
</head>

<body>
<p>&nbsp;</p>

<div align="center">
<table width="1300" border="0" cellpadding="0" cellspacing="0" id="cmsborder" align="center">

  <tr>
    <td height="54" valign="top" align="center">
    
    	<table width="	100%" border="0" cellpadding="0" cellspacing="0" align="center">

      <tr>

          <td width="780" valign="top" align="center">
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#CCCCCC">
            <!--DWLayoutTable-->
            <tr>
				<td><img src="images/logo.gif" style="width:400px; height:auto;"/></td>
			</tr>
			<tr>
              <td width="100%" height="23" valign="top" id="head1_sp1"><h2>Customer Form</h2></td>
              </tr>
            <tr>
              <td height="27" valign="top" id="topright_sp1">
				<table width="712">
					<tr>
						<td width="50%">
						<?php if ($_SESSION["name"]) { ?>
		                  <strong>Welcome - <?php echo $_SESSION["name"]; ?></strong>
						<?php } else { ?>
							&nbsp;
						<?php } ?>
						</td>
						<td align="right"><a href="main.php?logout=1">logout</a></td>
					</tr>
				</table>
				</td>
			
            </tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
            
			<tr> 
			  <td class="text" align="center"> 
              
			      <table border="1" frame="border" width="90%" bgcolor="WHITE">
					<tr>
                    	<td height="300" bgcolor="WHITE">
                        
                        <div align="center" id="customer_form">

                        <form method="post" action="customer_form.php"> 
                        <input type="hidden" name="cid" value="<?php echo $customer["id"]; ?>" />    
                       <table border="0" frame="border" cellspacing="0" cellpadding="2" width="90%" bgcolor="WHITE">
                            <tr>
                                <td align="right"><strong>Company Name: </strong></td>
                                <td><input type="text" name="name" id="name" size="60" value="<?php echo $customer["name"]; ?>"></td>
                            </tr>
                             <tr>
                                <td align="right"><strong>Address: </strong></td>
                                <td><input type="text" name="address" id="address" size="60" value="<?php echo $customer["address"]; ?>"></td>
                            </tr>
                             <tr>
                                <td align="right"><strong>Phone: </strong></td>
                                <td><input type="text" name="phone" id="phone" size="60" value="<?php echo $customer["phone"]; ?>"></td>
                            </tr>
                             <tr>
                                <td align="right"><strong>Fax: </strong></td>
                                <td><input type="text" name="fax" id="fax" size="60" value="<?php echo $customer["fax"]; ?>"></td>
                            </tr>
                             <tr>
                                <td align="right"><strong>Email: </strong></td>
                                <td><input type="text" name="email" id="email" size="60" value="<?php echo $customer["email"]; ?>"></td>
                            </tr>
                             <tr>
                                <td align="right" valign="top"><strong>Dispatch Notes: </strong></td>
                                <td><textarea rows="5" cols="62" name="dispatch_notes" id="dispatch_notes"><?php echo $customer["dispatch_notes"]; ?></textarea></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td align="right"><input type="submit" value="Make Changes">&nbsp;&nbsp;<input type="button" value="Cancel" onclick="javascript:location.href='customer_list.php';" /></td>
                            </tr>
                        </table>
                                
                        </div>
                        </td>
                    </tr>
	         		
		 		 </table>
			</td>
			</tr>
            <tr>
				<td>&nbsp;</td>
			</tr>
          </table></td>
        </tr>
      
      
      
    </table></td>
  </tr>
</table>
</div>
</body>
</html>
