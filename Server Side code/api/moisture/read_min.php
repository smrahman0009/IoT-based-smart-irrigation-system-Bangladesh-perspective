<?php
header("Access-Control-Allow-Origin: *");
// error_reporting(E_ERROR | E_PARSE);
// header("Content-Type: application/json; charset=UTF-8");
 
 
//Creating Array for JSON response
$response = array();
 
// Include data base connect class
$filepath = realpath (dirname(__FILE__));
require_once($filepath."/db_connect.php");
 
 // Connecting to database 
$db = new DB_CONNECT();	
$con = $db->getConnection();
$query = "SELECT * FROM mois_value";

 
 // Fire SQL query to get all data from weather
$result = mysqli_query($con,$query) or die(mysqli_error($con));
$db->close();
 
// Check for succesfull execution of query and no results found
if (mysqli_num_rows($result) > 0) {
    
	// Storing the returned array in response
    $response["moisture"] = array();
 
	// While loop to store all the returned response in variable
    while ($row = mysqli_fetch_array($result)) {
        // temperoary user array
        $moisture = array();
        $moisture["id"] = $row["id"];
        $moisture["min"] = $row["min"];
        $moisture["max"] = $row["max"];
		// Push all the items 
        array_push($response["moisture"], $moisture);
    }
    // On success
    $response["success"] = 1;
 
    // Show JSON response
    // echo json_encode($response);
    // print_r( $response['moisture'][0]["id"]);
    echo $response['moisture'][0]["min"].",".$response['moisture'][0]["max"];
}	
else 
{
    // If no data is found
	$response["success"] = 0;
    $response["message"] = "No moisture found";
 
    // Show JSON response
    json_encode($response);
}

?>