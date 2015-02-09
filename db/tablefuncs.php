<?php
/**********************************************************************************************************************
	
	Function sc_mysql_escape()

	Purpose: to call mysql_real_escape_string(), stripping slashes before only if necessary	
	

**********************************************************************************************************************/

function sc_mysql_escape($value) {

	if (is_string($value));
	
	// strip out slashes IF they exist AND magic_quotes is on
	if (get_magic_quotes_gpc() && (strstr($value,'\"') || strstr($value,"\\'"))) $value = stripslashes($value);

	// escape string to make it safe for mysql
	return @mysql_real_escape_string($value);
}

function sc_mysql_escape2($value) {

	if (is_string($value));
	
	// strip out slashes IF they exist AND magic_quotes is on
	//if (get_magic_quotes_gpc() && (strstr($value,'\"') || strstr($value,"\\'"))) $value = stripslashes($value);

	// escape string to make it safe for mysql
	
	return @mysql_real_escape_string($value);
	
}

/*********************************************************************************************************************************************

	Purpose:
		This function adds a single record to the DB
	
	Parameters:
		$table		table name (string)
		$data		array with field names as keys, and values rep. those field values
	

*********************************************************************************************************************************************/


function add_record($table,$data){

	// fix characters that MySQL doesn't like
	foreach(array_keys($data) as $field_name) {

		$data[$field_name] = sc_mysql_escape($data[$field_name]);
		
		if (!$field_string) {
			$field_string = "`$field_name`";
			$value_string = "'$data[$field_name]'";
		} else {
			$field_string .= ",`$field_name`";
			$value_string .= ",'$data[$field_name]'";
		}
	}
	
	$query = "INSERT INTO $table ($field_string) VALUES ($value_string)";
	//echo $query."<BR>";
	// if query is not successful, show error and return
	if (!mysql_query($query)) {
		echo "<b>Error:</b> ".mysql_error()."<br /><br /><b>Query was:</b> ".$query;
		return;
	}
	
	// grab rn# that was just added
	$insert_id = mysql_insert_id();
	// return record number of the record just added, in case we need it
	return $insert_id;
}

function add_record2($table,$data){

	// fix characters that MySQL doesn't like
	foreach(array_keys($data) as $field_name) {

		$data[$field_name] = sc_mysql_escape2($data[$field_name]);
		
		if (!$field_string) {
			$field_string = "`$field_name`";
			$value_string = "'$data[$field_name]'";
		} else {
			$field_string .= ",`$field_name`";
			$value_string .= ",'$data[$field_name]'";
		}
	}
	
	$query = "INSERT INTO $table ($field_string) VALUES ($value_string)";
	//echo $query."<BR>";
	// if query is not successful, show error and return
	if (!mysql_query($query)) {
		echo "<b>Error:</b> ".mysql_error()."<br /><br /><b>Query was:</b> ".$query;
		return;
	}
	
	// grab rn# that was just added
	$insert_id = mysql_insert_id();
	
	// return record number of the record just added, in case we need it
	return $insert_id;
}


/************************************************************************************************************************

	Purpose:
		To modify a record
		
	Parameters:
		$table		table name
		$data		array with field names as keys, and values rep. those field values
		$where		MySQL where statement, minus the "WHERE" text at the beginning
		
	
************************************************************************************************************************/

function modify_record($db, $table,$data,$where){

	// $data must be an array...if it's not...bail
	//if (!is_array($data)) return;

			foreach(array_keys($data) as $field_name) {
				$data[$field_name] = sc_mysql_escape($data[$field_name]);
				
				// if set string isn't set, set it....else append with a comma in between
				if (!$set_string) { 
					$set_string = "`$field_name` = '$data[$field_name]'";
				} else {
					$set_string = "$set_string, `$field_name` = '$data[$field_name]'";
				}
			}
			$query = "UPDATE $table SET $set_string WHERE $where";
			//echo $query."<BR>";
			if (!mysqli_query($db, $query)) {
				echo "<b>Query Failed:</b> ".mysql_error()."<br /><br /><b>Query was:</b> ".$query;
				return;
			}
}



function delete_record($table, $rn) {

		$query = "DELETE FROM $table WHERE ID = $rn";
		//echo $query."<BR>";

		if (mysql_query($query)) {
		} else {
			print "Failed to delete record";
		}
}

function delete_record_secondary($table, $rn, $id) {

		$query = "DELETE FROM $table WHERE $id = $rn";
		//echo $query."<BR>";

		if (mysql_query($query)) {
		} else {
			print "Failed to delete record";
		}
}

/*
Paramaters:
	$table is table to get records from
	$sortby is equal to a string of the name of the field you would like to sort by - ie "Name"
	$order is the order you want to sort in and can be either (0 or "ASC") for "ASC" or (1 or "DESC") for "DESC"
	$hide_records is used by functions that should not display hidden records. set it to 1 to hide records that are set as hidden in Record_Definition table
	$key_type - set to MYSQL_ASSOC to get only associative keys (no numbers)
	$force_array - if set to 1 and only one row was returned, it will be returned as an array
	$key - if set to a column name, the value in that column will be the key in the first level of the array
	
*/

function get_records($table,$select,$where=0,$sortby=0,$order=0,$test=0,$limit=0,$hide_records=0,$key_type=MYSQL_BOTH,$force_array=1,$key=""){
	global $SC;
	
	if ($where) $where_string = "WHERE $where";
	if (!$select) $select = "*";
	if ($order==0 || $order=="ASC") $order_string = "ASC";
	if ($order==1 || $order=="DESC") $order_string = "DESC";
	if ($sortby) $sort_string = "ORDER BY $sortby $order_string";
	if ($limit) $limit_string = $limit;
	
	// below section is for hiding records when you are logged in as a non developer
	if ($hide_records) {
		// if doing a search, set the query string
		if ($where) {
			$search_string = "AND $where";
			$search_string = str_replace("record_number","$table.record_number",$search_string);
			$search_string = str_replace("Table_Name","$table.Table_Name",$search_string);
		}
		$select = str_replace(",",",$table.",$select);
		$select = "$table.$select";

		// set query
		$qry = "SELECT $select 
		FROM $table
		LEFT JOIN Record_Definition rd ON $table.record_number = rd.Record AND '$table' = rd.Table_Name
		WHERE ((
		rd.Table_Name = '$table' AND rd.Hide_Record != 1
		) OR rd.Record IS NULL OR rd.Table_Name IS NULL) $search_string $sort_string $limit_string";		
	} else {
		$qry = "SELECT $select FROM $table $where_string $sort_string $limit_string";
	}
	
	//if ($test) print "query is $qry<br>";

	// grab a md5 hash of the qry for reference later
	$hash = md5($qry);
	
	// check query cache in session for result of same qry statement
	if ($SC['qry_cache'][$hash]) {
		// if qry result was cached during this same page load, then just use that cached result,
		// instead of querying DB again
		if ($SC['qry_cache'][$hash]['load_time'] == $SC['load_time']) {
			$result = $SC['qry_cache'][$hash]['result'];
		}
	}
	
	// if here, then qry is new for this page load.
	if (!isset($result)) {
		$result = sc_query($qry,$key_type,$force_array,$test,$key);
		// store qry in cache for reuse only during this page load
		$SC['qry_cache'][$hash]['result'] = $result;
		$SC['qry_cache'][$hash]['load_time'] = $SC['load_time'];
	}
	
	return $result;
}

/*
Function sc_query - to query MySQL database and return array of data

Parameters:
$qry - the SQL query statement
$type - default is MYSQL_ASSOC which will return an associative array. Can set to MYSQL_BOTH or MYSQL_?
$force_array - by default, this function will only return an array when there is more than 1 row of data. Setting this to 1 will return an array even if it only contains 1 row
$test - prints the query to the browser

*/

function sc_query($qry,$type=MYSQL_ASSOC,$force_array=0,$test=0,$key=''){
	global $SC;

	$SC['qry_count']++;
	
	//print "qry: $qry<br>\n";
	
	if (!$qry) return;

	if ($test) print "Query is: $qry<br>";

	$result = @mysql_query ($qry);
	$error = mysql_error();
	if (!$error) {
		if (is_resource($result)) {
			while ($row = mysql_fetch_array ($result, $type)) {
				// fix to remove slashes added when magic_quotes_runtime is enabled
				if(get_magic_quotes_runtime()) {
					foreach (array_keys($row) as $key) {
						$row[$key] = stripslashes($row[$key]);
					}
				}

				// if a field name was passed as $key, then use the value of that column as a key....
				if ($key) {
					$records[$row[$key]] = $row;
				} else {
					// use a numeric key
					$records[] = $row;
				}
			}
		}
		if (count($records) == 1 && !$force_array) {
			$records = $records[0]; // if only one row is returned, no need to return an array of rows, just a single row
			if (count(array_keys($records)) == 1) { // if only one key for this single row, just return the value - no array needed
			$keys = array_keys($records);
			$key = $keys[0];
			$records = $records[$key];
			}
		}
		if ($records) {
			return $records;
		}
	
	} else {
		sc_show_diag("
			<b>MySQL error:</b> $error<br><br>
			<b>Query was:</b> $qry<br>
		");
	}
}
?>
