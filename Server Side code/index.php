<?php
header("Access-Control-Allow-Origin: *");
    require_once "api/moisture/db_connect.php";
    $db = new DB_CONNECT();
    $con = $db->getConnection();

    // $con = mysqli_connect('localhost', 'root', '', 'irrigation') or die('Can not connect to Database');

    $query = "SELECT * FROM tbl_sensor_data ORDER BY id DESC LIMIT 10";
    if(!$result = mysqli_query($con, $query)){
        echo mysqli_error($con);
        // $db->close();
    }

//$row_motor =
// $motor = array();
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smart Irrigation System</title>
    
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style1.css">
	<script  src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700|Roboto+Slab:400,700" rel="stylesheet">
     <!--<script type="text/javascript" src="jquery-3.4.1.min.js"></script> -->
 
	

</head>
<body>
    <button id="ref_btn" class="btn btn-info">Refresh</button>
    <center><h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Smart &nbsp; Irrigation &nbsp; System</h1></center>
    
    <div class="center">
        <div align="center" class="form">
            <div class="toLeft3"><br>
                <h5>Moisture Value</h5>
                <p id="mos">
                    <img src = 'humidity.png' /> 
                    <span id = "mois_value">00.00</span>
                </p>
                <div class="">
                    <h4><span id="mtr_stat">Motor Status</span> <i>[<span id="mtr_mode"></span>]</i></h4>
                    <!--<h5><span ></span></h5>-->
                    <p id="humi_stat">0 %</p><i id="sens_stat"></i>
                    
                </div>
            </div>
            <div class="toLeft4">
                <div>
                    <label>Current Minimum: </label> <span id="curMin">0.00</span> <br><br>
                </div>
                <div>
                    <label>Current Maximum: </label> <span id="curMax">0.00</span><br><br>
                </div>
                <div>
                    <label>Current Motor Delay: </label> <span id="curDel">0.00</span>ms
                </div>
            </div>
        </div>
    </div><br>
    
        <div class="container">
        
        <div class="center3">
            
            <div class="toLeft">
                <h5><span>MOTOR MODE</span></h5>
                <button type="button" id="auto_mode" class="btn btn-success">Automatic</button>
                
                <div class="isDisable">
                    <form action="http://safeirrigation.site/api/motor/update.php" method="GET">
                        <div class="form-group">
                            <br>
                            <label>Motor Delay Value</label>
                            <input type="number" name="delay" class="form-control" id="delay_val" placeholder="For 1s Type 1000.." maxlength="7" size="4">
                        </div>
                        <input type="button" name="submit" id="submitBtn2" class="btn btn-secondary" value="Submit">
                    </form>
                </div>
                <p><span id="turnAuto"></span></p>
            </div>
            <div class="toLeft">
                <br><br>
                <div class="isDisable">
                    <form action="http://safeirrigation.site/api/moisture/insert_min.php" method="GET">
                        <div class="form-group">
                            <label>Minimum Moisture Value </label>
                            <input type="number" name="min" class="form-control" id="min_val" placeholder="From 0-1024" maxlength="4" size="4">
                        </div>
                        <div class="form-group">
                            <label>Maximum Moisture Value </label>
                            <input type="number" name="max" class="form-control" id="max_val" placeholder="From 0-1024" maxlength="4" size="4">
                        </div>
                        <input type="button" name="submit" id="submitBtn" class="btn btn-secondary" value="Submit">
                    </form>
                </div>
            </div>

            <div class="toLeft2">
                <h5><span>MOTOR MODE</span></h5>
                <br>
                <button type="button" id="manual_mode" class="btn btn-warning" >&nbsp;Manual &nbsp;&nbsp;</button> <br><br>
                <div class="isManual">
                    <div>
                        <button type="button" id="D3-on" class="btn btn-primary isManual" ><b>MOTOR ON</b></button>
                    </div> <br>
                    <div>
                        <button type="button" id="D3-of" class="btn btn-danger isManual" ><b>MOTOR OFF</b></button>
                    </div>
                </div>
                <p><span id="turnManual"></span></p>
            </div>
        </div>
        <br>
    </div>
    <br>
    <!-- <button id="stopAjax"> Stop Refresh Ajax</button> -->
    <div class="div1" align="center">
        <center><h3>Latest 10 Moisture Level Value</h3></center>
        <table id="table1" class="table-bordered table-sm">
            
            <tr class="bg-info">
                <td>ID</td>
                <td>Moisture Value</td>
                <td> Date </td>
                <td> Time </td>
            </tr>
        
        
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=$row['mos']?></td>
                        <td><?=$row['ddate']?></td>
                        <td><?=$row['ttime']?></td>
                    </tr>
            <?php   }
            } 
            
            ?>
            
        </table>
    </div>

    <div class="container text-center p-2 mt-2">
        <form action="api/moisture/read.php" method="GET">
            <button class="btn btn-info">View All Data</button>
        </form>
    </div>

<!-- JavaScript -->
<script>
    // alert("hello");
var ajax = new XMLHttpRequest();
var method = "GET";
// var url = "api/moisture/read_latest.php";
var url = "http://safeirrigation.site/api/moisture/read_latest.php";
var asynchronous = true;
var new_value;
var auto_flag;
var min = 0;
var max = 1024;
var percent;
var ref_flag = false;
var once_flag = true;
var man_flag = true;
var user_min=0;
var user_max=0;

function getMinMax(){
    if(ref_flag || once_flag){
        // alert("2");
        $.ajax({
            type: "GET",
            url: 'http://safeirrigation.site/api/moisture/read_min.php',
            async: false,
            // url: 'http://safeirrigation.site/api/moisture/read_latest.php',
            datatype: "text",
            success: function(data){
                // alert("3");
                let temp = data.split(",");
                user_min = parseInt(temp[0]);
                user_max = parseInt(temp[1]);
                console.log("-- Get min max: "+user_min+", "+user_max);
                $("#curMin").html(user_min);
                $("#curMax").html(user_max);
            }
        });

        $.ajax({
            type: "GET",
            url: 'api/motor/motor_stat.php?id=3',
            async: false,
            // url: 'http://safeirrigation.site/api/moisture/read_latest.php',
            datatype: "text",
            success: function(data){
                // alert("3");
                let temp = data;
                if(temp == "of"){
                    $("#mtr_stat").html("<b> Motor is Off </b>");
                    console.log("-- motor stat: "+temp);
                }else if(temp == "on"){
                    $("#mtr_stat").html("<b> Motor is On </b>");
                    console.log("-- motor stat: "+temp);
                }
                
            }
        });
        
        $.ajax({
            type: "GET",
            url: 'api/motor/read_delay.php?id=3',
            async: false,
            // url: 'http://safeirrigation.site/api/moisture/read_latest.php',
            datatype: "text",
            success: function(data){
                // alert("3");
                let temp = data;
                $("#curDel").html(temp);
                console.log("-- Get delay: "+temp);
            }
        });

    }
}



function getData(){
    ajax.open(method, url, asynchronous);
    console.log("-- getData ");

    if(ref_flag == true || once_flag==true){
        //sending request
        ajax.send();
        //receive request from php
        ajax.onreadystatechange = function(){
            // alert(this.readyState);
            if(this.readyState == 4 && this.status == 200){
                document.getElementById('mois_value').innerHTML = this.responseText;
                // alert(this.responseText);
                new_value = this.responseText;
                console.log("Ajax response :"+this.responseText + " (getData)");
                // alert("dfsdfsdf");
                flag = true;
            }
        }
    }
    
}

function getCurrentMode(){
    let flag;
    if(ref_flag || once_flag){
        console.log("-- getCurrentMode: "+ref_flag+", "+once_flag);
        $.ajax({
            type: "GET",
            url: "http://safeirrigation.site/api/motor/current_mode.php",
            async: false,
            success: function(data){
                if(data == "man"){
                    flag = false;
                    console.log("Man mode: "+auto_flag+ ", "+ data);
                    // return false;
                }else if(data == "auto"){
                    flag = true;
                    console.log("auto mode: "+auto_flag+", "+data);
                    // return true;
                }else{
                    alert(data + " (getCurrentMode)");
                }
            }
        });
    }
    return flag;
}



getMinMax();
// ajax.open(method, url, asynchronous);
// //sending request
// ajax.send();
getData();
auto_flag = getCurrentMode();
// console.log(auto_flag +" 2");
// console.log(man_flag +" 2");
if(auto_flag == false){
    console.log(auto_flag +" 2");
    $("#min_val").attr("disabled", true);
    $("#max_val").attr("disabled", true);
    $("#delay_val").attr("disabled", true);
    $("#submitBtn").attr("disabled", true);
    $("#submitBtn2").attr("disabled", true);
    $("#D3-on").attr("disabled", false);
    $("#D3-of").attr("disabled", false);
    // if(man_flag){
        motorOnOff();
        $("#mtr_mode").html("Manual Mode");
    // }
}else if(auto_flag == true ){
    motorOnOff();
    console.log(auto_flag +" 1");
    $("#D3-on").attr("disabled", true);
    $("#D3-of").attr("disabled", true);
    $("#min_val").attr("disabled", false);
    $("#max_val").attr("disabled", false);
    $("#delay_val").attr("disabled", false);
    $("#submitBtn").attr("disabled", false);
    $("#submitBtn2").attr("disabled", false);
    $("#mtr_mode").html("Auto Mode");
}
updateMotorStat();



// setInterval(function(){
//     getData();
//     
//     // updateMotorStat();
//     // alert("sdf");
//     updateTable();
// }, 20000);

// setInterval(updateMotorStat, 20000);

   //auto motor on and off
function motorOnOff(){
    console.log("-- motorOnOff");
    if(ref_flag || once_flag){
        $.ajax({
            type: "GET",
            // url: 'api/moisture/read_latest.php',
            url: 'http://safeirrigation.site/api/moisture/read_latest.php',
            async: false,
            datatype: "text",
            success: function(data){
                new_value = data;
                // alert(new_value);
                console.log("1" + auto_flag + user_min + user_max + " (motorOnOff)");
                
                // if(new_value>340 && new_value<921 && auto_flag==true){
                if(new_value>=user_min && new_value<=user_max && auto_flag==true){
                    // var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=on";
                    // var url = "api/motor/update.php?id=3&status=on";
                    var url = "http://safeirrigation.site/api/motor/update.php?id=3&status=on";
                    console.log("2");
                    
                    $.ajax({
                        type: "GET",
                        url: url,
                        async: false,
                        datatype: "json",
                        success: function(data){
                            console.log("3");
                            $("#D3-on").css({"background-color":"#1034a6"}); // blue on
                            $("#D3-of").css({"background-color":"#acb1b9"}); // red off
                            $("#mtr_stat").html("<b>Motor is On</b>");
                            if(new_value>450 && new_value<800){
                                $("#sens_stat").html(" (Soil) ");
                            }
                            
                        }
                    });
                }else if ((new_value<user_min || new_value>user_max) && auto_flag==true){
                // }else if ((new_value<339 || new_value>922) && auto_flag==true){
                    // var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=of";
                    console.log("4" + auto_flag + " (motorOnOff)");
                    // var url = "api/motor/update.php?id=3&status=of";
                    var url = "http://safeirrigation.site/api/motor/update.php?id=3&status=of";
                    console.log("5");

                    $.ajax({
                        type: "GET",
                        url: url,
                        async: false,
                        datatype: "json",
                        success: function(data){
                            console.log("6");
                            $("#D3-on").css("background-color", "#acb1b9"); // blue off
                            $("#D3-of").css("background-color", "#ff0000"); // red on
                            $("#mtr_stat").html("<b>Motor is Off</b>");
                            if(new_value<370){
                                $("#sens_stat").html(" (Water) ");
                            }else if(new_value>930){
                                $("#sens_stat").html(" (Air) ");
                            }
                        }
                    });
                }else{
                    console.log("else else" + " (motorOnOff)");
                }
            }
        });
    }
}



function updateMotorStat(){
    // alert("1");
    console.log("-- updateMotorStat");
    if(ref_flag || once_flag){
        // alert("2");
        $.ajax({
            type: "GET",
            // url: 'api/moisture/read_latest.php',
            url: 'http://safeirrigation.site/api/moisture/read_latest.php',
            async: true,
            datatype: "text",
            success: function(data){
                // alert("3");
                let temp = data;
                let percentage = ((max - temp ) * 100) / max;
                $("#humi_stat").html("Soil Humidity <b><i>"+Math.round(percentage)+" %</i></b>");
                console.log("Update Motor Stat: "+temp + " (updateMotorStat)");
            }
        });
    }
    
}


function updateTable(){
    if(ref_flag || once_flag){
        $.ajax({
            type: "GET",
            url: "http://safeirrigation.site/api/moisture/read_table.php",
            async: true,
            success: function(data){
                
                $(".div1").html(data);
                console.log("refreshing table..");
            }
        });
    }
    
}



document.getElementById('D3-on').addEventListener('click', function() {
// var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=on";
// var url = "api/motor/update.php?id=3&status=on";
var url = "http://safeirrigation.site/api/motor/update.php?id=3&status=on";
alert("on");
percent = ((max - new_value ) * 100) / max;
console.log("Percent " + percent);

    $.ajax({
        type: "GET",
        url: url,
        async: true,
        datatype: "json",
        success: function(data){
            $("#D3-on").css("background-color", "#1034a6"); // blue on
            $("#D3-of").css("background-color", "#acb1b9"); // red off
            $("#mtr_stat").html("<b>- Motor is On -</b>");
            $("#humi_stat").html("Soil Humidity <b><i>"+Math.round(percent)+" %</i></b>");
        }
    });
});

document.getElementById('D3-of').addEventListener('click', function() {
    // var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=of";
    // var url = "api/motor/update.php?id=3&status=of";
    var url = "http://safeirrigation.site/api/motor/update.php?id=3&status=of";
    alert("off");
    percent = ((max - new_value ) * 100) / max;
    console.log("Percent " + percent);
    $.ajax({
        type: "GET",
        url: url,
        async: true,
        datatype: "json",
        success: function(data){
            $("#D3-on").css("background-color", "#acb1b9"); // blue off
            $("#D3-of").css("background-color", "#ff0000"); // red on
            $("#mtr_stat").html("<b>- Motor is Off -</b>");
            $("#humi_stat").html("Soil Humidity <b><i>"+Math.round(percent)+" %</i></b>");
        }
    });
});


$(document).ready(function(){

    $("#auto_mode").click(function(){
        alert("auto clicked");
        auto_flag = true;
        $("#D3-on").attr("disabled", true);
        $("#D3-of").attr("disabled", true);
        $("#D3-on").css({"background-color": "blue"});
        $("#D3-of").css({"background-color": "red"});
        $("#mtr_mode").html("Auto Mode");
        $("#turnAuto").html("");
        $("#min_val").attr("disabled", false);
        $("#max_val").attr("disabled", false);
        $("#delay_val").attr("disabled", false);
        $("#submitBtn").attr("disabled", false);
        $("#submitBtn2").attr("disabled", false);
        man_flag = false;

        $.ajax({
            type: "GET",
            url: "http://safeirrigation.site/api/motor/update_mode.php?mode=auto",
            async: true
        });
    });


    $("#manual_mode").click(function(){
        alert("manual clicked");
        auto_flag = false;
        $("#D3-on").attr("disabled", false);
        $("#D3-of").attr("disabled", false);
        $("#D3-on").css({"background-color": "blue"});
        $("#D3-of").css({"background-color": "red"});
        $("#mtr_mode").html("Manual Mode");
        $("#turnManual").html("");
        $("#min_val").attr("disabled", true);
        $("#max_val").attr("disabled", true);
        $("#delay_val").attr("disabled", true);
        $("#submitBtn").attr("disabled", true);
        $("#submitBtn2").attr("disabled", true);
        $.ajax({
            type: "GET",
            url: "http://safeirrigation.site/api/motor/update_mode.php?mode=man",
            async: true
        });
        man_flag = false;

    });

    $("#ref_btn").click(function(){
        alert("refreshing");
        ref_flag = true;
        getMinMax();
        getData();
        getCurrentMode();
        if(auto_flag == false){
            console.log(auto_flag +" 2");
            $("#min_val").attr("disabled", true);
            $("#max_val").attr("disabled", true);
            $("#delay_val").attr("disabled", true);
            $("#submitBtn").attr("disabled", true);
            $("#submitBtn2").attr("disabled", true);
            $("#D3-on").attr("disabled", false);
            $("#D3-of").attr("disabled", false);
            
                motorOnOff();
            
        }else if(auto_flag == true ){
            motorOnOff();
            console.log(auto_flag +" 1");
            $("#D3-on").attr("disabled", true);
            $("#D3-of").attr("disabled", true);
            $("#min_val").attr("disabled", false);
            $("#max_val").attr("disabled", false);
            $("#delay_val").attr("disabled", false);
            $("#submitBtn").attr("disabled", false);
            $("#submitBtn2").attr("disabled", false);
        }
        updateMotorStat();
        // alert("sdf");
        updateTable();
        ref_flag = false;
        once_flag = false;

    });

    $("#submitBtn").click(function(){
        var min = $("#min_val").val();
        var max = $("#max_val").val();
        alert("sub" + min + max);
        
        if(min.length>0 && max.length>0){ // checking min max empty or not
            console.log("+"+min+max);
            if(max>min){
                $.ajax({
                    type: "GET",
                    url: "http://safeirrigation.site/api/moisture/insert_min.php?min="+min+"&max="+max+"",
                    async: true,
                    success: function(data){
                        $("#min_val").val("");
                        $("#max_val").val("");
                    }
                });
            }else{
                $("#min_val").val("");
                $("#max_val").val("");
            }
            
        }else if(min.length>0){
            console.log("-"+min);
            if(min>0 && min<1022){
                $.ajax({
                    type: "GET",
                    url: "http://safeirrigation.site/api/moisture/insert_min.php?min="+min+"",
                    async: true,
                    success: function(data){
                        $("#min_val").val("");
                    }
                });
            }else{
                $("#min_val").val("");
                $("#max_val").val("");
            }
        }else if(max.length>0){
            console.log("*"+max);
            if(max>1 && max<1024){
                $.ajax({
                    type: "GET",
                    url: "http://safeirrigation.site/api/moisture/insert_min.php?max="+max+"",
                    async: true,
                    success: function(data){
                        $("#max_val").val("");
                    }
                });
            }else{
                $("#min_val").val("");
                $("#max_val").val("");
            }
        }else{
            alert("--Error--");
        }
        
    });


    $("#submitBtn2").click(function(){
        let delay = $("#delay_val").val();
        // alert(delay);
        if(delay.length < 1){
            alert("Enter Delay value");
            if(delay < 1){
                alert("Negative Delay Error");
            }else{
                alert("err 1 -" + delay)
            }
        }else{
            $.ajax({
                type: "GET",
                url: "http://safeirrigation.site/api/motor/update.php?delay="+delay+"",
                async: true,
                success: function(data){
                    $("#delay_val").val("");
                }
            });
        }

    });


    $(".isDisable").mouseenter(function(){
        // if($("#mtr_mode").)
        // alert("clicked"+auto_flag);
        if(!auto_flag){
            $("#turnAuto").html("Turn On Automatic Mode First").css({
                "color": "red", "font-weight":"bold", "font-size":"12px"
            });

        }else{
            $("#turnAuto").html("");
        }

    });


    $(".isManual").mouseenter(function(){
        // if($("#mtr_mode").)
        // alert("clicked"+auto_flag);
        if(auto_flag){
            // alert(auto_flag);
            $("#turnManual").html("Turn On Manual Mode First").css({
                "color": "red", "font-weight":"bold", "font-size":"12px"
            });

        }else{
            $("#turnManual").html("");
        }

    });


});



</script>

</body>
</html>
