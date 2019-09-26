<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['id']) && isset($_GET['status']) && isset($_GET['delay'])) {
 
    $id = $_GET['id'];
    $status= $_GET['status'];
    $delay = $_GET['delay'];
    if($delay == ""){
        $delay = 20000; //20sec
    }
    
 
    // Include data base connect class
	$filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");

	// Connecting to database
    $db = new DB_CONNECT();
    $con = $db->getConnection();
 
    $query = "UPDATE motor SET status= $status, delay=$delay WHERE id = $id";
    
    // echo $query;
 
	// Fire SQL query to update LED status data by id
    $result = mysqli_query($con, $query);
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of LED status (status)
        $response["success"] = 1;
        $response["message"] = "Current motor status is '$status' and delay is '$delay'";
 
        // Show JSON response
        echo json_encode($response);
        // echo "Update Successful";
    } else {
        
    }
}else if (isset($_GET['id']) && isset($_GET['status']) ) {
 
    $id = $_GET['id'];
    $status= $_GET['status'];
    
 
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
    require_once($filepath."/db_connect.php");

    // Connecting to database
    $db = new DB_CONNECT();
    $con = $db->getConnection();
 
    $query = "UPDATE motor SET status= '$status' WHERE id = $id";
    
    // echo $query;
 
    // Fire SQL query to update LED status data by id
    $result = mysqli_query($con, $query);
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of LED status (status)
        $response["success"] = 1;
        $response["message"] = "Current motor status is '$status'";
 
        // Show JSON response
        echo json_encode($response);
        // echo "Update Successful";
    } else {
        $response["success"] = 0;
        $response["message"] = "Something has been wrong";
     
        // Show JSON response
        echo json_encode($response);
    }
} else if (isset($_GET['delay'])) {
 
    $delay = $_GET['delay'];
    $flag =true;

    if(strlen($delay) < 1){
        $flag = false;
        if($delay < 1){
            $flag = false;
        }
    }

    if($delay == ""){
        $delay = 20000; //20sec
    }
    
 
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
    require_once($filepath."/db_connect.php");

    // Connecting to database
    $db = new DB_CONNECT();
    $con = $db->getConnection();
    $query2 = "UPDATE motor SET delay='$delay' WHERE id=3";
    
    // echo $query2;
    if($flag){
        $result2 = mysqli_query($con, $query2);
     
        // Check for succesfull execution of query and no results found
        if ($result2) {
            // successfully updation of LED status (status)
            $response["success"] = 1;
            $response["message"] = "Current motor and delay is '$delay'";
     
            // Show JSON response
            echo json_encode($response);
            // echo "Update Successful";
        }else {
            // Failed to insert data in database
            $response["success"] = 0;
            $response["message"] = "Something has been wrong";
     
            // Show JSON response
            echo json_encode($response);
        }
    }

    
}else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
    // echo "Update Unsuccessful";
}
$db->close();
// header("Location: ../../index.php");
?>