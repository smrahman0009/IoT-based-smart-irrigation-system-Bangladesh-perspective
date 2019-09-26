<?php
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Include data base connect class
$filepath = realpath (dirname(__FILE__));
require_once($filepath."/db_connect.php");

 // Connecting to database
$db = new DB_CONNECT();
$con = $db->getConnection();
 
// Check if we got the field from the user
if (isset($_GET["id"])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM motor m INNER JOIN mois_value mv ON mv.id=3";
 
     // Fire SQL query to get weather data by id
    $result = mysqli_query($con, $query);
    $db->close();
	
	//If returned result is not empty
    if (!empty($result)) {

        // Check for succesfull execution of query and no results found
        if (mysqli_num_rows($result) > 0) {
			
			// Storing the returned array in response
            $result = mysqli_fetch_array($result);
			
			// temperoary user array
            $motor = array();
            $motor["id"] = $result["id"];
            $motor["status"] = $result["status"];
            $motor["delay"] = $result["delay"];
            $motor["new_value"] = $result["new_value"];
            $motor["mode"] = $result["mode"];
            $motor["min"] = $result["min"];
            $motor["max"] = $result["max"];
          
            $response["success"] = 1;

            $response["motor"] = array();
			
			// Push all the items 
            array_push($response["motor"], $motor);
 
            // Show JSON response
            echo json_encode($response);
        } else {
            // If no data is found
            $response["success"] = 0;
            $response["message"] = "No data on motor found";
 
            // Show JSON response
            echo json_encode($response);
        }
    } else {
        // If no data is found
        $response["success"] = 0;
        $response["message"] = "No data on motor found";
 
        // Show JSON response
         echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // echoing JSON response
     echo json_encode($response);
}
?>