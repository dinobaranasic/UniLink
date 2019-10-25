<?php
require_once 'func/dbinfo.php';
$msg="";

if(isset($_POST['submit'])) //Chech if Login is pressed in HTML
{
    XamppDb();
    //creating vars for $_POST to send
    $email= XamppDb()->real_escape_string($_POST['email']);
    $password= XamppDb()->real_escape_string($_POST['password']);
    if ($email==""||$password=="") {
        $msg="Please check your inputs?";
    }
    else {
        $result = XamppDb()->query("SELECT id, password, isEmailConfirmed FROM users WHERE email='$email'");

        if ($result->num_rows>0) {

            $data= $result->fetch_array();

            if (password_verify($password,$data['password'])) {
                if ($data['isEmailConfirmed']==0) {
                    $msg="Please verify your email";
                }
                else {
                    $msg="You have been login :)";
                }
            } 
            else {
                $msg="Please check your inputs?";
            }
        }
        else {
            $msg="Please check your inputs?";
        }
    }
}
/**************************************************************************************************************************** */
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LogIn</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row justfy-content-center">
            <div class="col-md-6 col-md-offset-3">
                <br>

                <!--php msg-->
                <?php if ($msg!="") {
                        # code...
                        echo $msg;
                    }
                    ?>
                <br>

                <form method="POST" action="login.php">
                    <input class="form-control" name="email" type="email" placeholder="Email..."><br>
                    <input class="form-control" name="password" type="password" placeholder="Password..."><br>
                    <input class="btn-primary" type="submit" name="submit" value="LogIn"><br>


                    <br>
                    <br>

                </form>
            </div>
        </div>
    </div>
</body>

</html>