<?php 
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
 //Creating Array for JSON response
$response = array();

$cflag = $_REQUEST['cflag'];
$mos = $_REQUEST['mos'];


	if($cflag == true){
		// Include data base connect class
		$filepath = realpath (dirname(__FILE__));
		require_once($filepath."/db_connect.php");
		 
		 // Connecting to database 
		$db = new DB_CONNECT();	
		$query = "SELECT * FROM tbl_sensors_data";
		 
		 // Fire SQL query to get all data from weather
		$result = mysqli_query($db->connect(),$query) or die(mysqli_error($db->connect()));
		 
		// Check for succesfull execution of query and no results found
		if (mysqli_num_rows($result) > 0) {
		    
			// Storing the returned array in response
		    $response["moisture"] = array();
		 
			// While loop to store all the returned response in variable
		    while ($row = mysqli_fetch_array($result)) {
		        // temperoary user array
		        $moisture = array();
		        $moisture["id"] = $row["id"];
		        $moisture["mos"] = $row["mos"];
				// Push all the items 
		        array_push($response["moisture"], $moisture);
		    }
		    // On success
		    $response["success"] = 1;
		 
		    // Show JSON response
		    // echo json_encode($response);
		}	
		else 
		{
		    // If no data is found
			$response["success"] = 0;
		    $response["message"] = "No moisture found";
		 
		    // Show JSON response
		    // echo json_encode($response);
		}
	}
	

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Read All Views</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script  src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>
</head>
<body>

	<div class="container">
		<form action="read_duration.php" method="GET">
			<select>
				<option value="oneDay" name="oneDay">1 Day</option>
				<option value="twoDay" name="twoDay">2 Days</option>
				<option value="threeDay" name="threeDay">3 Days</option>
				<option value="fiveDay" name="fiveDay">5 Days</option>
				<option value="sevenDay" name="sevenDay">7 Days</option>
				<option value="fifteenDay" name="fifteenDay">15 Days</option>
				<option value="thirtyDay" name="thirtyDay">30 Days</option>
			</select>
		</form>
	</div>

</body>
</html>