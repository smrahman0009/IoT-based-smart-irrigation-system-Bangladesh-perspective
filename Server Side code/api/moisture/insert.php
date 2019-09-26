<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['mos'])) {
 
    $mos = $_GET['mos'];
    // echo $mos;
 
    // Include data base connect class
    $filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");
 
 
    // Connecting to database 
    $db = new DB_CONNECT();
    $con = $db->getConnection();
    date_default_timezone_set("Asia/Dhaka");
    $ddate = date('Y-m-d');
    $ttime = date('h:i:s');

    $query = "INSERT INTO `tbl_sensor_data` (`mos`, `ddate`, `ttime`) VALUES ('$mos','$ddate' ,'$ttime' )";
    $query2 = "UPDATE motor SET new_value='$mos' WHERE id=3";
 
    // Fire SQL query to insert data in weather
    $result = mysqli_query($con,$query);
    $result2 = mysqli_query($con, $query2);
    $db->close();
 
    // Check for succesfull execution of query
    if ($result && $result2) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "Moisture successfully inserted.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
        // Failed to insert data in database
        $response["success"] = 0;
        $response["message"] = "Something has been wrong";
 
        // Show JSON response
        echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>