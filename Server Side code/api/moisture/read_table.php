<?php
// header("Access-Control-Allow-Origin: *");
// error_reporting(E_ERROR | E_PARSE);
// header("Content-Type: application/json; charset=UTF-8");

 
// Include data base connect class
$filepath = realpath (dirname(__FILE__));
require_once($filepath."/db_connect.php");
 
 // Connecting to database 
$db = new DB_CONNECT();	
$con = $db->getConnection();

// Check for succesfull execution of query and no results found
?>

<!DOCTYPE html>
<html>
<head>
    <title>Moisture Sensor Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
        
        <div class="div1" align="center">
            <center><h3>Latest 10 Moisture Level Value</h3></center>
            <table id="table1" class="table-bordered table-sm">
                
                <tr class="bg-info">
                    <td>ID</td>
                    <td>Moisture Level</td>
                    <td> Date </td>
                    <td> Time </td>
                </tr>
                <?php
                  $query = "SELECT * FROM tbl_sensor_data ORDER BY id DESC LIMIT 10";
                  $result2 = mysqli_query($con, $query);
                  
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
            </table>
        </div>

</body>
</html>
