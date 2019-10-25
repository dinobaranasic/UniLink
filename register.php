<?php
    // Load other files
    require_once 'vendor/autoload.php';
    require_once 'func/dbinfo.php';
    require_once 'func/mail.php';
    require_once 'func/token.php';
    
    $msg="";
    
    if(isset($_POST['submit'])) //Chech if Submit is pressed in HTML
    {
        //create connetion to xampp database
        XamppDb();
        //creating vars for $_POST to send
        $study= XamppDb()->real_escape_string($_POST['study']);
        $name= XamppDb()->real_escape_string( $_POST['name']); //real esc str, for security from: NUL (ASCII 0), \n, \r, \, ', ", and Control-Z.
        $surname= XamppDb()->real_escape_string($_POST['surname']);
        $email= XamppDb()->real_escape_string($_POST['email']);
        $password= XamppDb()->real_escape_string($_POST['password']);
        $cPassword= XamppDb()->real_escape_string($_POST['cPassword']);
        
        if ((preg_match("/@student.mev.hr$/",$email))||(preg_match("/@mev.hr$/",$email))) 
        {
            # code...
            if ($name==""||$surname==""||$email==""||$password==""||$study=="") {
                    $msg="All fields required";
                }
            else {
                $result = XamppDb()->query("SELECT id FROM users WHERE email='$email'");
                if ($result->num_rows>0) {
                        $msg="Email already exist in the database";
                    }
                else {
                    //create confirmation token for email verification
                    $token=Token();
                    //hash from password so we as administrators dont see the password
                    $hassPassword=password_hash($password,PASSWORD_BCRYPT);
                    //covert study to short input for database
                        switch ($study) {
                            case 'Computer Science':
                                # code...
                                $study='cs';
                                break;
                            case 'Tourism and Sport Management':
                                # code...
                                $study='tsm';
                                break;
                            case 'Sustainable Development':
                                # code...
                                $study='sd';
                                break;
                            default:
                                # code...
                                break;
                        }
                    //send the data to database
                    XamppDb()->query("INSERT INTO users (study,name,surname,email,password, isEmailConfirmed, token) 
                    VALUES ('$study','$name','$surname','$email','$hassPassword','0','$token'); ");
                    //mail funciton, send confirmation email
                    Mailer($email,$name,$token);
                    //confirmation message
                    $msg="You have been registerd, please VERIFY your Email";
                    }
                }
        }   
        else{
            $msg="All fields required or you entered wrong e-mail domain!";
        }
    }
    /**************************************************************************************************************************************/
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./register.css">
    <!-- JS scripts -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"
        integrity="sha256-lPE3wjN2a7ABWHbGz7+MKBJaykyzqCbU96BJWjio86U=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TimelineMax.min.js"
        integrity="sha256-fIkQKQryItPqpaWZbtwG25Jp2p5ujqo/NwJrfqAB+Qk=" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="./app.js"></script>
    <!-- JS scripts end -->
</head>

<body>
    <div id="forma" name="forma" class="container">
        <div class="login-box">

            <div class="signin-reg" style="height: 0%; display: none;">
                <h2>Sign In - Register</h2>
            </div>
            <br>
            <!-- ******************************************************* -->

            <form method="POST" action="register.php">
                <div class="form-class" style="height: 0%; display: none;">
                    <div class="form-group ">
                        <label class="regText" for="regStudy">Choose your study course:</label>
                        <select id="inputState" class="form-control" name="study" id="study" type="study">
                            <option>Computer Science</option>
                            <option>Tourism and Sport Management</option>
                            <option>Sustainable Development</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <!-- <label for="regFirstName">First name:</label> -->
                            <input type="name" class="form-control" id="name" name="name" placeholder="First name">
                        </div>
                        <div class="form-group col-md-6">
                            <!-- <label for="regLastName">Last name:</label> -->
                            <input type="surname" class="form-control" id="surname" name="surname"
                                placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- <label for="regEmail">Email:</!-->
                        <input class="form-control" name="email" type="email"
                            placeholder="Email: @student.mev.hr/mev.hr"><br>
                        <label class="regText" for="regEmail">Password:</label>
                        <input class="form-control" name="password" type="password"
                            placeholder="Enter your desired password"><br>
                        <input class="form-control" name="cPassword" type="password" placeholder="Confirm Password"><br>
                    </div>
                </div>
                <div name="signInBtn" class="text-center"style="height: 0%; display: none;">
                    <button type="submit" name="submit" class="btn btn-primary form-control">Sign in</button>
                </div>
            </form>

            <div class="phpMsg" id="phpMsg" name="phpMsg">
                <!--php msg-->
                <?php 
                        if ($msg!="") {
                        echo $msg;    }
                    ?>
            </div>
            <!-- ******************************************************* -->

        </div>

    </div>
</body>

</html>