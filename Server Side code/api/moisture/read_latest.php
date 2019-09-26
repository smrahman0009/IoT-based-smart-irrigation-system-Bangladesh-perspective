<?php

    header("Access-Control-Allow-Origin: *");
    // header("Content-Type: application/json; charset=UTF-8");

    // $con =  mysqli_connect('localhost', 'id9184002_root', '12345', 'id9184002_arduino') or die('Can not connect to Database');
    $filepath = realpath (dirname(__FILE__));
    require_once($filepath . "/db_connect.php");
    
    $first_row = array();

    $db = new DB_CONNECT();
    $con = $db->getConnection();

    $query = "SELECT * FROM tbl_sensor_data ORDER BY id DESC LIMIT 1";

    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $db->close();

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            // echo $row['mos'];
            $first_row = $row;
            echo $first_row['mos'];
        }
    }
?>