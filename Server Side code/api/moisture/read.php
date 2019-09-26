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
$query = "SELECT * FROM tbl_sensor_data";

 
 // Fire SQL query to get all data from weather
$result = mysqli_query($con,$query) or die(mysqli_error($con));
// $db->close();
 
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
    json_encode($response);
}	
else 
{
    // If no data is found
	$response["success"] = 0;
    $response["message"] = "No moisture found";
 
    // Show JSON response
    json_encode($response);
}
//-----------------//
$result2 = mysqli_query($con,$query);

if(!$result2){
    echo mysqli_error($con);
}
// $db->close();
$chart_data = "";

while ($row2 = mysqli_fetch_array($result2)) {
  $chart_data .= "{ date:'" . $row2["ddate"] . "', mos:" . $row2["mos"] . ", id:" . $row2["id"] . ", }, ";
}

$chart_data = substr($chart_data, 0, -2);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Moisture Sensor Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style_read.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700|Roboto+Slab:400,700" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


</head>
<body>
    <h1 class="display-5 text-center p-2 pb-4 sticky-top">View Data &nbsp; as &nbsp; Table and Graph</h1>

    <div class="row">
        <div class="container table-wrapper-scroll-y my-custom-scrollbar col-md-4 ">

            <table class="table table-bordered table-striped ">

                <thead>
                    <tr class="table-info">

                        <th scope="col">ID</th>
                        <th scope="col">Moisture Data</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>

                    </tr>

                </thead>

                <tbody>
                  <?php
                  $result2 = mysqli_query($con, $query);
                  $db->close();
                  if (mysqli_num_rows($result2) > 0) {
                    // print_r($result2);
                    while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                      <tr>
                        <td><?= $row2['id'] ?></td>
                        <td><?= $row2['mos'] ?></td>
                        <td><?= $row2['ddate'] ?></td>
                        <td><?= $row2['ttime'] ?></td>
                      </tr>

                    <?php }  }   ?>
                </tbody>
            </table>
        </div>


        <div class="container col-md-7">
            <div id="area_chart" class="chart"></div>
        </div>

    </div>

    <div class="container text-center w-50 p-2 mt-2">
        <a class="btn btn-info btn-lg btn-block " href="http://safeirrigation.site/" role="button"> Return</a>
    </div>

<script>

Morris.Area({
  element:'area_chart',
  data:[<?php echo $chart_data ?>],
  xkey:'date',
  ykeys:['mos',],
  labels:['moisture'],
  hideHower:'auto',
  stacked:true
});

</script>

</body>
</html>