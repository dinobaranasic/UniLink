<?php
global $connection;
function XamppDb(){
    $DBservername="localhost";
    $DBusername="root";
    $DBpassword=null;
    $DBname="test";

    $connection = new mysqli($DBservername,$DBusername,$DBpassword,$DBname); //Database connection

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
     }
    //  echo "Debug: Database Connected successfully<br>";

     return $connection;

}

?>