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

if ($_REQUEST["enabledid"])
{
	$qry = "UPDATE customers SET disabled = 0 WHERE id = ".$_REQUEST["enabledid"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}

if ($_REQUEST["disabledid"])
{
	$qry = "UPDATE customers SET disabled = 1 WHERE id = ".$_REQUEST["disabledid"];
	mysqli_query($connection, $qry) or die (mysqli_error()); 
}

$qry = "SELECT * FROM customers ORDER BY disabled, name";
$customers = mysqli_query($connection, $qry) or die (mysqli_error()); 
$customer = mysqli_fetch_array($customers);

?>


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
						<table width="100%">
                        	<tr>
                            	<td><strong>Name</strong></td>
                                <td><strong>Address</strong></td>
                                <td><strong>Phone</strong></td>
                                <td><strong>Fax</strong></td>
                                <td><strong>Email</strong></td>
                                <td><strong>Actions</strong></td>
                            </tr>
                            <?php 
							$bgcolor = "WHITE";
							do{ 
							
								if ($customer["disabled"] == "1")
								{
									$bgcolor = "#F06428";
								} else {
									if ($bgcolor == "WHITE")
									{
										$bgcolor = "#E4E4E4";
									} else {
										$bgcolor = "WHITE";
									}
								}
								
							?>
                            <tr bgcolor="<?php echo $bgcolor; ?>">
                            	<td><?php echo $customer["name"]; ?></td>
                                <td><?php echo $customer["address"]; ?></td>
                                <td><?php echo $customer["phone"]; ?></td>
                                <td><?php echo $customer["fax"]; ?></td>
                                <td><?php echo $customer["email"]; ?></td>
                                <?php if ($customer["disabled"] == 1) { ?>
                                <td align="center"><a href="customer_form.php?cid=<?php echo $customer["id"]; ?>">edit</a>&nbsp;&nbsp;<a href="customer_list.php?enabledid=<?php echo $customer["id"]; ?>">enable</a></td>
                                <?php } else { ?>
                                <td align="center"><a href="customer_form.php?cid=<?php echo $customer["id"]; ?>">edit</a>&nbsp;&nbsp;<a href="customer_list.php?disabledid=<?php echo $customer["id"]; ?>">disable</a></td>
                                <?php } ?>
                            </tr>
                            <?php } while ($customer = mysqli_fetch_array($customers)); ?>
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
