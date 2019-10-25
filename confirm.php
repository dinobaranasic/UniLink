<?php
    function redirectReg()
    {
        header('Location: register.php');
        exit();
    }
    function redirectLogin()
    {
        header('Location: login.php');
        exit();
    }
    if (!isset($_GET['email']) || !isset($_GET['token'])) {
        redirectReg();
    }
    else {
        //stuff for database connection, error with xamppDB()
        $DBservername="localhost";
        $DBusername="root";
        $DBpassword=null;
        $DBname="test";
    
        $connection = new mysqli($DBservername,$DBusername,$DBpassword,$DBname); //Database connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        echo "<br>Debug:<br>Confirm.php database connected successfully<br>";

        $email=$connection->real_escape_string($_GET['email']);
        $token=$connection->real_escape_string($_GET['token']);

        //check if data from users match
        $result=$connection->query("SELECT id FROM users WHERE email='$email' AND token='$token' AND isEmailConfirmed=0 ");
        print_r($result);
        echo("<br>");
        

        if ($result->num_rows > 0) {
            # code...
            $connection->query("UPDATE users SET isEmailConfirmed=1, token='' WHERE email='$email'");
            $msg= "Your Email has been verified you can LogIn now!";
            redirectLogin();
            }
        // else {
        //     # code...
        //     redirect();
        // }
    }
?>