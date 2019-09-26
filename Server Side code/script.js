
var ajax = new XMLHttpRequest();
var method = "GET";
var url = "../api/moisture/read_latest.php";
var asynchronous = true;
var flag;
var new_value;

if(!flag){
    flag = false;
}

    // ajax.open(method, url, asynchronous);
    
    // //sending request
    // ajax.send();
getData();

function getData(){
    ajax.open(method, url, asynchronous);

    //sending request
    ajax.send();
    //receive request from php
    ajax.onreadystatechange = function(){
        // alert(this.readyState);
        if(this.readyState == 4 && this.status == 200){
            document.getElementById('mois_value').innerHTML = this.responseText;
            // alert(this.responseText);
            new_value = this.responseText;
            console.log(this.responseText);
            // alert("dfsdfsdf");
        }
    }
}

if(flag == true){
    setInterval(function(){
        getData();
        motorOnOff();
    }, 10000);
}
    

$(document).ready(function(){
    $("#stopAjax").click(function(){
        flag = false;
    });
});

    //auto motor on and off
function motorOnOff(){
    <?php include_once "../api/moisture/read_latest.php";
        echo "Latest Data " . $first_row['mos'];
    ?>
    new_value = "<?php echo $first_row['mos']; ?>";
    alert(new_value);
    if(new_value >= 30){
        var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=on";
        $.getJSON(url, function(data) {
            console.log(data);
            alert("k");
            $("#D3-on").css({"background-color":"#1034a6"}); // blue on
            $("#D3-of").css({"background-color":"#acb1b9"}); // red off
            $("#mtr_stat").html("<b>---Motor is On---</b>");
        });
    }else if (new_value < 30){
        var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=of";
        $.getJSON(url, function(data) {
            console.log(data);
            $("#D3-on").css("background-color", "#acb1b9"); // blue off
            $("#D3-of").css("background-color", "#ff0000"); // red on
            $("#mtr_stat").html("<b>---Motor is Off---</b>");
        });
    }
}


document.getElementById('D3-on').addEventListener('click', function() {
var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=on";
$.getJSON(url, function(data) {
    console.log(data);
    $("#D3-on").css("background-color", "#1034a6"); // blue on
    $("#D3-of").css("background-color", "#cd5c5c"); // red off
    $("#mtr_stat").html("<b>---Motor is On---</b>");

    });
});

document.getElementById('D3-of').addEventListener('click', function() {
    var url = "https://smartfive.000webhostapp.com/api/motor/update.php?id=3&status=of";
    $.getJSON(url, function(data) {
        console.log(data);
        $("#D3-on").css("background-color", "#468284"); // blue off
        $("#D3-of").css("background-color", "#ff0000"); // red on
        $("#mtr_stat").html("<b>---Motor is Off---</b>");
    });
});