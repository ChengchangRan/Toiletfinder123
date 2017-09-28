<?php
require("phpsqlinfo_dbinfo.php");

// Gets data from URL parameters.
$type = $_GET['type'];
$gender = $_GET['gender'];
$baby = $_GET['baby'];
$disable = $_GET['disable'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$description = $_GET['description'];

// Opens a connection to a MySQL server.
$connection=mysql_connect ("35.188.198.174", $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Sets the active MySQL database.
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Inserts new row with place data.
$query = sprintf("INSERT INTO markers " .
         " (id, type, gender, baby, disable, lat, lng, description ) " .
         " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
         mysql_real_escape_string($type),
         mysql_real_escape_string($gender),
		 mysql_real_escape_string($baby),
		 mysql_real_escape_string($disable),
         mysql_real_escape_string($lat),
         mysql_real_escape_string($lng),
         mysql_real_escape_string($description));

$result = mysql_query($query);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}

?>