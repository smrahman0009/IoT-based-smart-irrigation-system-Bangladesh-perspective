<?php 

header("Access-Control-Allow-Origin: *");
// error_reporting(E_ERROR | E_PARSE);
// header("Content-Type: application/json; charset=UTF-8");

 
// Include data base connect class
$filepath = realpath (dirname(__FILE__));
require_once($filepath."/db_connect.php");
 
 // Connecting to database 
$db = new DB_CONNECT();	
$con = $db->getConnection();

// Check for succesfull execution of query and no results found

$query = "SELECT status FROM motor WHERE id=3";
$result = mysqli_query($con, $query);

if(!$result){
	echo "Failed";
}else{
	$row = mysqli_fetch_assoc($result);
	echo $row['status'];
}

?>