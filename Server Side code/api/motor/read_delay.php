<?php

header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_REQUEST['id']) ) {
 
    $delay = $_REQUEST['id'];
    
 
    // Include data base connect class
	$filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");

	// Connecting to database
    $db = new DB_CONNECT();
    $con = $db->getConnection();
    $query = "SELECT * FROM motor where id=$delay";
    
    // echo $query;
 
	// Fire SQL query to update LED status data by id
    $result = mysqli_query($con, $query);
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of LED status (status)
        $response["success"] = 1;
        $response["message"] = "Current motor delay is '$delay'";
        $row = mysqli_fetch_assoc($result);
        echo $row['delay'];
 
        // Show JSON response
        // echo json_encode($response);
        // echo "Update Successful";
    } else {
        
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
    // echo "Update Unsuccessful";
}
$db->close();
?>