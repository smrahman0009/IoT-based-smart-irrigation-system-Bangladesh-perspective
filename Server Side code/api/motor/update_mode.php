<?php 
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_REQUEST['mode'])) {
	$filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");

	// Connecting to database
    $db = new DB_CONNECT();
    $con = $db->getConnection();

    $mode = $_REQUEST['mode'];
 
    $query = "UPDATE motor SET mode='$mode' WHERE id = 3";
    $result = mysqli_query($con, $query);

    if ($result) {
        // successfully updation of LED status (status)
        $response["success"] = 1;
        $response["message"] = "Current motor status is '$status' and delay is '$delay'";
 
        // Show JSON response
        // echo json_encode($response);
        echo "Done";
    } else {
        
    }
    
}else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    // echo json_encode($response);
    echo "Undone";
}
$db->close();


 ?>