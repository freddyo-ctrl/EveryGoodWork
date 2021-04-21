<?php

// This function returns a new database connection
function dbConnect() {

    /*$host = "localhost"; 
    $user = "cwhutacl_everygoodwork"; 
    $pwd = "ctec4350egwont";
    $database = "cwhutacl_4350";
    $port = "3306";*/

    $host = "localhost"; 
	$user = "root"; 
	$pwd = "";
	$database = "everygoodwork";
	$port = "3306";
 
	// initiate a new mysqli object to connect to the Database.  Store the mysqli object in a variable $conn.
	$conn = new mysqli($host, $user, $pwd, $database, $port) or die("could not connect to server");

	// return $conn to the fucntion call
	return $conn;
}
?>