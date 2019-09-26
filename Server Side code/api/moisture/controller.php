<?php 
	

	// $temp = $_REQUEST['temp'];
	// $hum = $_REQUEST['hum'];
	$cflag = $_REQUEST['cflag'];
	$mos = $_REQUEST['mos'];

	if($cflag == false){
		header("location: insert.php?&mos=".$mos."&cflag=false");
	}else if($cflag == true){
		header("location: insert_duration.php?&mos=".$mos."&cflag=true");
	}




 ?>