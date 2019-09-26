<?php 
header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
error_reporting(E_ALL & ~E_NOTICE);
$response = array();
	
if(isset($_REQUEST['min']) && isset($_REQUEST['max'])){
	$min = $_REQUEST['min'];
	$max = $_REQUEST['max'];
	$flag;

    // alert("Enter Minimum and Maximum Values");
    if($min>$max || $min<0 || $min>1022 || $max<2 || $max>1024){
        // alert("Minimum can not be greater than Maximum");
        $flag = false;
    }else{
    	$flag = true;
    }
    

	$filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");

	$db = new DB_CONNECT();
    $con = $db->getConnection();
    // update min max value
	if($min!="" && $max!="" && $flag==true){
		$query = "UPDATE mois_value SET min='$min', max='$max' WHERE id=3";
		$result = mysqli_query($con, $query);

		if($result){
			$response["success"] = 1;
	        $response["message"] = "Moisture value updated min='$min' max='$max'";
	        echo json_encode($response);
	        echo $query;
		}else {
	        // Failed to insert data in database
	        $response["success"] = 0;
	        $response["message"] = "Something has been wrong 1";
	 
	        // Show JSON response
	        echo json_encode($response);
	    }
	}else{
		echo " --" . $flag. "--";
		echo "Data not Inserted";
	}

	$con->close();
	// header("Location: ../../index.php");
}else if(isset($_REQUEST['min'])){
	$min = $_REQUEST['min'];

	$flag;

    // alert("Enter Minimum and Maximum Values");
    if($min<0 || $min>1022){
        // alert("Minimum can not be greater than Maximum");
        $flag = false;
    }else{
    	$flag = true;
    }
    

	$filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");

	$db = new DB_CONNECT();
    $con = $db->getConnection();
    // update min max value
	if($min!="" && $flag==true){
		$query2 = "UPDATE mois_value SET min=$min WHERE id=3";
		$result2 = mysqli_query($con, $query2);

		if($result2){
			$response["success"] = 1;
	        $response["message"] = "Moisture value updated min=$min";
	        echo json_encode($response);
		}else {
	        // Failed to insert data in database
	        $response["success"] = 0;
	        $response["message"] = "Something has been wrong 2";
	        $response["sql"] = $query2;
	 
	        // Show JSON response
	        echo json_encode($response);
	    }
	}else{
		// echo " --" . $flag. "--";
		echo "Data not Inserted";
	}

	$con->close();
	// header("Location: ../../index.php");
}else if(isset($_REQUEST['max'])){

	$max = $_REQUEST['max'];
	$flag;

    // alert("Enter Minimum and Maximum Values");
    if($max<2 || $max>1024){
        // alert("Minimum can not be greater than Maximum");
        $flag = false;
    }else{
    	$flag = true;
    }
    

	$filepath = realpath (dirname(__FILE__));
	require_once($filepath."/db_connect.php");

	$db = new DB_CONNECT();
    $con = $db->getConnection();
    // update min max value
	if($max!="" && $flag==true){
		$query3 = "UPDATE mois_value SET max=$max WHERE id=3";
		$result3 = mysqli_query($con, $query3);

		if($result3){
			$response["success"] = 1;
	        $response["message"] = "Moisture value updated max=$max";
	        echo json_encode($response);
		}else {
	        // Failed to insert data in database
	        $response["success"] = 0;
	        $response["message"] = "Something has been wrong 3";
	 
	        // Show JSON response
	        echo json_encode($response);
	    }
	}else{
		echo " --" . $flag. "--";
		echo "Data not Inserted";
	}

	$con->close();
	// header("Location: ../../index.php");
}

?>