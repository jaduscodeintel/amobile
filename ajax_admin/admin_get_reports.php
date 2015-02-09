<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../db/DB.php');

if ($_POST)
{
	switch($_POST["stype"])
	{
		case "Calls per Customer":
			calls_per_customer();
			break;
		
		case "Calls per Month":
			calls_per_month();
			break;
			
		case "Calls per State":
			calls_per_state();
			break;
			
		case "Calls per Tech":
			calls_per_tech();
			break;
			
		case "Calls per Dispatcher":
			calls_per_Dispatcher();
			break;
		
		default:
			echo "No Type Chosen";
		
	}
}

function calls_per_customer()
{
	global $connection;
	if ($_POST["sdate"] && $_POST["edate"])
	{
		$qry = "SELECT count(*) as customer_count, customers.name FROM dispatch LEFT JOIN customers ON (company_id = customers.id) WHERE date_time BETWEEN '".$_POST["sdate"]." - INTERVAL 1 day' AND '".$_POST["edate"]." + INTERVAL 1 day' GROUP BY company_id ORDER BY customer_count DESC";
	} else {
		
		switch($_POST["dtype"])
		{
			case "This Month":
				$qry = "SELECT count(*) AS customer_count, customers.name FROM dispatch LEFT JOIN customers ON (company_id = customers.id) WHERE MONTH(date_time) = MONTH(CURDATE()) AND YEAR(date_time) = YEAR(CURDATE()) AND cancelled = 0 GROUP BY company_id ORDER BY customer_count DESC";
				break;
			
			case "Last Month":
				$qry = "SELECT count(*) AS customer_count, customers.name FROM dispatch LEFT JOIN customers ON (company_id = customers.id) WHERE MONTH(date_time) = MONTH(CURDATE() - INTERVAL 1 month) AND YEAR(date_time) = YEAR(CURDATE() - INTERVAL 1 month) AND cancelled = 0 GROUP BY company_id ORDER BY customer_count DESC";
				break;
			
			case "Last 6 Months":
				$qry = "SELECT count(*) AS customer_count, customers.name, dispatch.company_id FROM dispatch LEFT JOIN customers ON (company_id = customers.id) WHERE date_time BETWEEN DATE_SUB(curdate(), INTERVAL 6 MONTH) AND CURDATE() AND cancelled = 0 GROUP BY company_id ORDER BY customer_count DESC";
				break;
				
			case "This Year":
				$qry = "SELECT count(*) AS customer_count, customers.name FROM dispatch LEFT JOIN customers ON (company_id = customers.id) WHERE YEAR(date_time) = YEAR(CURDATE()) AND cancelled = 0 GROUP BY company_id ORDER BY customer_count DESC";
				break;
			
			default:
				echo "No Type Chosen";
			
		}
	
		
	}
//	echo "<hr>";
//	echo $qry;
//	echo "<hr>";
	
	echo "<h1>Calls Per Customer ";
	if ($_POST["sdate"] && $_POST["edate"])
	{
		echo $_POST["sdate"]." to ".$_POST["edate"];
	} else {
		echo $_POST["dtype"];
	}
	echo "</h1><hr>";
	$ccounts = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$ccount = mysqli_fetch_array($ccounts);	
	echo "<table>";
	$bgcolor="WHITE";
	do{
		echo "<tr bgcolor = '".$bgcolor."'><td width='50' align='right'><strong>".$ccount["customer_count"]."</strong></td><td width='10'>&nbsp;</td><td>".$ccount["name"]."</td>&nbsp;</td><td>".$ccount["company_id"]."</td></tr>";
	if ($bgcolor == "WHITE")
	{
		$bgcolor = "#EFEFEF";
	} else {
		$bgcolor = "WHITE";
	}
	
	} while ($ccount = mysqli_fetch_array($ccounts));
	echo "</table>";
}

function calls_per_month()
{
	global $connection;
	
	$qry = "SELECT COUNT( * ) AS customer_count, MONTHNAME( dispatch.date_time ) AS month, YEAR(dispatch.date_time) as year FROM dispatch WHERE MONTHNAME(dispatch.date_time) IS NOT NULL AND YEAR(dispatch.date_time) IS NOT NULL GROUP BY month";

	
	echo "<h1>Calls Per Month</h1><hr>";
	$ccounts = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$ccount = mysqli_fetch_array($ccounts);	
	echo "<table>";
	$bgcolor="WHITE";
	do{
		echo "<tr bgcolor = '".$bgcolor."'><td width='50' align='right'><strong>".$ccount["customer_count"]."</strong></td><td width='10'>&nbsp;</td><td>".$ccount["month"]." ".$ccount["year"]."</td></tr>";
	if ($bgcolor == "WHITE")
	{
		$bgcolor = "#EFEFEF";
	} else {
		$bgcolor = "WHITE";
	}
	
	} while ($ccount = mysqli_fetch_array($ccounts));
	echo "</table>";
}

function calls_per_state()
{
	global $connection;
	if ($_POST["sdate"] && $_POST["edate"])
	{
		$qry = "SELECT count(*) AS customer_count, states.name FROM dispatch LEFT JOIN states ON (state_id = states.id) WHERE date_time BETWEEN '".$_POST["sdate"]." - INTERVAL 1 day' AND '".$_POST["edate"]." + INTERVAL 1 day' GROUP BY state_id DESC";
	} else {
		
		switch($_POST["dtype"])
		{
			case "This Month":
				$qry = "SELECT count(*) AS customer_count, states.name FROM dispatch LEFT JOIN states ON (state_id = states.id) WHERE MONTH(date_time) = MONTH(CURDATE()) AND YEAR(date_time) = YEAR(CURDATE()) GROUP BY state_id DESC";
				break;
			
			case "Last Month":
				$qry = "SELECT count(*) AS customer_count, states.name FROM dispatch LEFT JOIN states ON (state_id = states.id) WHERE MONTH(date_time) = MONTH(CURDATE() - INTERVAL 1 month) AND YEAR(date_time) = YEAR(CURDATE() - INTERVAL 1 month) GROUP BY state_id DESC";
				break;
			
			case "Last 6 Months":
				$qry = "SELECT count(*) AS customer_count, states.name FROM dispatch LEFT JOIN states ON (state_id = states.id) WHERE date_time BETWEEN DATE_SUB(curdate(), INTERVAL 6 MONTH) AND CURDATE() GROUP BY state_id DESC";
				break;
				
			case "This Year":
				$qry = "SELECT count(*) AS customer_count, states.name FROM dispatch LEFT JOIN states ON (state_id = states.id) WHERE YEAR(date_time) = YEAR(CURDATE()) GROUP BY state_id DESC";
				break;
			
			default:
				echo "No Type Chosen";
			
		}
	
		
	}
	
	echo "<h1>Calls Per State ";
	if ($_POST["sdate"] && $_POST["edate"])
	{
		echo $_POST["sdate"]." to ".$_POST["edate"];
	} else {
		echo $_POST["dtype"];
	}
	echo "</h1><hr>";
	$ccounts = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$ccount = mysqli_fetch_array($ccounts);	
	echo "<table>";
	$bgcolor="WHITE";
	do{
		echo "<tr bgcolor = '".$bgcolor."'><td width='50' align='right'><strong>".$ccount["customer_count"]."</strong></td><td width='10'>&nbsp;</td><td>".$ccount["name"]."</td></tr>";
	if ($bgcolor == "WHITE")
	{
		$bgcolor = "#EFEFEF";
	} else {
		$bgcolor = "WHITE";
	}
	
	} while ($ccount = mysqli_fetch_array($ccounts));
	echo "</table>";
}

function calls_per_tech()
{
	global $connection;
	if ($_POST["sdate"] && $_POST["edate"])
	{
		$qry = "SELECT COUNT( * )  AS customer_count, techs.name FROM dispatch LEFT JOIN tech_dispatch ON ( tech_dispatch.did = dispatch.id ) LEFT JOIN techs ON ( techs.id = tech_dispatch.tid ) WHERE date_time BETWEEN  '".$_POST["sdate"]." - INTERVAL 1 day' AND  '".$_POST["edate"]." + INTERVAL 1 day' AND techs.name IS NOT NULL GROUP BY techs.id ORDER BY customer_count DESC";
	} else {
		
		switch($_POST["dtype"])
		{
			case "This Month":
				$qry = "SELECT COUNT( * )  AS customer_count, techs.name FROM dispatch LEFT JOIN tech_dispatch ON ( tech_dispatch.did = dispatch.id ) LEFT JOIN techs ON ( techs.id = tech_dispatch.tid ) WHERE MONTH(date_time) = MONTH(CURDATE()) AND YEAR(date_time) = YEAR(CURDATE()) AND techs.name IS NOT NULL GROUP BY techs.id ORDER BY customer_count DESC";
				break;
			
			case "Last Month":
				$qry = "SELECT COUNT( * )  AS customer_count, techs.name FROM dispatch LEFT JOIN tech_dispatch ON ( tech_dispatch.did = dispatch.id ) LEFT JOIN techs ON ( techs.id = tech_dispatch.tid ) WHERE MONTH(date_time) = MONTH(CURDATE() - INTERVAL 1 month) AND YEAR(date_time) = YEAR(CURDATE() - INTERVAL 1 month) AND techs.name IS NOT NULL GROUP BY techs.id ORDER BY customer_count DESC";
				break;
			
			case "Last 6 Months":
				$qry = "SELECT COUNT( * )  AS customer_count, techs.name FROM dispatch LEFT JOIN tech_dispatch ON ( tech_dispatch.did = dispatch.id ) LEFT JOIN techs ON ( techs.id = tech_dispatch.tid ) WHERE date_time BETWEEN DATE_SUB(curdate(), INTERVAL 6 MONTH) AND CURDATE() AND techs.name IS NOT NULL GROUP BY techs.id ORDER BY customer_count DESC";
				break;
				
			case "This Year":
				$qry = "SELECT COUNT( * )  AS customer_count, techs.name FROM dispatch LEFT JOIN tech_dispatch ON ( tech_dispatch.did = dispatch.id ) LEFT JOIN techs ON ( techs.id = tech_dispatch.tid ) WHERE YEAR(date_time) = YEAR(CURDATE()) AND techs.name IS NOT NULL GROUP BY techs.id ORDER BY customer_count DESC";
				break;
			
			default:
				echo "No Type Chosen";
			
		}
	
		
	}
	
	echo "<h1>Calls Per Tech ";
	if ($_POST["sdate"] && $_POST["edate"])
	{
		echo $_POST["sdate"]." to ".$_POST["edate"];
	} else {
		echo $_POST["dtype"];
	}
	echo "</h1><hr>";
	$ccounts = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$ccount = mysqli_fetch_array($ccounts);	
	echo "<table>";
	$bgcolor="WHITE";
	do{
		echo "<tr bgcolor = '".$bgcolor."'><td width='50' align='right'><strong>".$ccount["customer_count"]."</strong></td><td width='10'>&nbsp;</td><td>".$ccount["name"]."</td></tr>";
	if ($bgcolor == "WHITE")
	{
		$bgcolor = "#EFEFEF";
	} else {
		$bgcolor = "WHITE";
	}
	
	} while ($ccount = mysqli_fetch_array($ccounts));
	echo "</table>";
}

function calls_per_dispatcher()
{
	global $connection;
	if ($_POST["sdate"] && $_POST["edate"])
	{
		$qry = "SELECT COUNT( * )  AS customer_count, dispatchers.dispatcher FROM dispatch LEFT JOIN dispatchers ON ( dispatchers.id = dispatch.dispatcher_id ) WHERE date_time BETWEEN  '".$_POST["sdate"]." - INTERVAL 1 day' AND  '".$_POST["edate"]." + INTERVAL 1 day' AND dispatchers.dispatcher IS NOT NULL GROUP BY dispatchers.id ORDER BY customer_count DESC";
	} else {
		
		switch($_POST["dtype"])
		{
			case "This Month":
				$qry = "SELECT COUNT( * )  AS customer_count, dispatchers.dispatcher FROM dispatch LEFT JOIN dispatchers ON ( dispatchers.id = dispatch.dispatcher_id ) WHERE MONTH(date_time) = MONTH(CURDATE()) AND YEAR(date_time) = YEAR(CURDATE()) AND dispatchers.dispatcher IS NOT NULL GROUP BY dispatchers.id ORDER BY customer_count DESC";
				break;
			
			case "Last Month":
				$qry = "SELECT COUNT( * )  AS customer_count, dispatchers.dispatcher FROM dispatch LEFT JOIN dispatchers ON ( dispatchers.id = dispatch.dispatcher_id ) WHERE MONTH(date_time) = MONTH(CURDATE() - INTERVAL 1 month) AND YEAR(date_time) = YEAR(CURDATE() - INTERVAL 1 month) AND dispatchers.dispatcher IS NOT NULL GROUP BY dispatchers.id ORDER BY customer_count DESC";
				break;
			
			case "Last 6 Months":
				$qry = "SELECT COUNT( * )  AS customer_count, dispatchers.dispatcher FROM dispatch LEFT JOIN dispatchers ON ( dispatchers.id = dispatch.dispatcher_id ) WHERE date_time BETWEEN DATE_SUB(curdate(), INTERVAL 6 MONTH) AND CURDATE() AND dispatchers.dispatcher IS NOT NULL GROUP BY dispatchers.id ORDER BY customer_count DESC";
				break;
				
			case "This Year":
				$qry = "SELECT COUNT( * )  AS customer_count, dispatchers.dispatcher FROM dispatch LEFT JOIN dispatchers ON ( dispatchers.id = dispatch.dispatcher_id ) WHERE YEAR(date_time) = YEAR(CURDATE()) AND dispatchers.dispatcher IS NOT NULL GROUP BY dispatchers.id ORDER BY customer_count DESC";
				break;
			
			default:
				echo "No Type Chosen";
			
		}
	
		
	}

	echo "<h1>Calls Per Dispatcher ";
	if ($_POST["sdate"] && $_POST["edate"])
	{
		echo $_POST["sdate"]." to ".$_POST["edate"];
	} else {
		echo $_POST["dtype"];
	}
	echo "</h1><hr>";
	$ccounts = mysqli_query($connection, $qry) or die (mysqli_error()); 
	$ccount = mysqli_fetch_array($ccounts);	
	echo "<table>";
	$bgcolor="WHITE";
	do{
		echo "<tr bgcolor = '".$bgcolor."'><td width='50' align='right'><strong>".$ccount["customer_count"]."</strong></td><td width='10'>&nbsp;</td><td>".$ccount["dispatcher"]."</td></tr>";
	if ($bgcolor == "WHITE")
	{
		$bgcolor = "#EFEFEF";
	} else {
		$bgcolor = "WHITE";
	}
	
	} while ($ccount = mysqli_fetch_array($ccounts));
	echo "</table>";
}



 ?>
