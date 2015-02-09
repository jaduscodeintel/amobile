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
	$qry = "INSERT INTO customers (name, address, phone, fax, email, dispatch_notes) VALUES ('".$_POST["name"]."','".$_POST["address"]."','".$_POST["phone"]."','".$_POST["fax"]."','".$_POST["email"]."','".$_POST["dispatch_notes"]."')";
	//echo $qry."<BR>";
	mysqli_query($connection, $qry) or die (mysqli_error()); 
	$newid = mysqli_insert_id($connection);
	
	if ($_POST["did"])
	{
		if ($_POST["carrier"])
		{
			$qry = "UPDATE dispatch SET carrier_id ='".$newid."' WHERE id = ".$_POST["did"];
		} else {
			$qry = "UPDATE dispatch SET company_id ='".$newid."' WHERE id = ".$_POST["did"];
		}
		//echo $qry;
		mysqli_query($connection, $qry) or die (mysqli_error()); 
		
		?>
		<script language="javascript">
			parent.tabs2_click(<?php echo $_POST["did"]; ?>);
			parent.jQuery.fancybox.close();
		</script>
<?php 
	} else {
		?>
		<script language="javascript">
			parent.close_dispatch_reset();
			parent.jQuery.fancybox.close();
		</script>
<?php 
	}
} ?>
<style>
#customer_form
{
	font-family:Verdana, Geneva, sans-serif;
	font-size: 9px;	
}
</style>
</head>

<body>
<p>&nbsp;</p>

<div align="center" id="customer_form">

<form method="post" action="add_customer_form.php">     
<input type="hidden" value="<?php echo $_REQUEST["id"]; ?>" name="did">
<input type="hidden" value="<?php echo $_REQUEST["carrier"]; ?>" name="carrier">         
<table border="0" frame="border" cellspacing="0" cellpadding="2" width="90%" bgcolor="WHITE">
    <tr>
        <td align="right"><strong>Company Name: </strong></td>
        <td><input type="text" name="name" id="name" size="60"></td>
    </tr>
     <tr>
        <td align="right"><strong>Address: </strong></td>
        <td><input type="text" name="address" id="address" size="60"></td>
    </tr>
     <tr>
        <td align="right"><strong>Phone: </strong></td>
        <td><input type="text" name="phone" id="phone" size="60"></td>
    </tr>
     <tr>
        <td align="right"><strong>Fax: </strong></td>
        <td><input type="text" name="fax" id="fax" size="60"></td>
    </tr>
     <tr>
        <td align="right"><strong>Email: </strong></td>
        <td><input type="text" name="email" id="email" size="60"></td>
    </tr>
     <tr>
        <td align="right" valign="top"><strong>Dispatch Notes: </strong></td>
        <td><textarea rows="5" cols="62" name="dispatch_notes" id="dispatch_notes"></textarea></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td align="right"><input type="submit" value="Add Customer"></td>
    </tr>
</table>
		
</div>
</body>
</html>
