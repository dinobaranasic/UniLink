<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once 'vendor/autoload.php';
    function Mailer($email,$name,$token)
    {
        /***************************************************************************************************************/
            // PHPMailer code -> GMAIL setup m4rko.sk0la
            // Import PHPMailer classes into the global namespace
            // These must be at the top of your script, not inside a function

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_OFF;                         // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'm4rk0.sk0l4@gmail.com';                // SMTP username
                $mail->Password   = 'l45t4v3c';                             // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('marko.lastavec@mev.hr', 'Marko');
                $mail->addAddress($email, $name);                           // Add a recipient
                
                /*
                // Attachments
                $mail->addAttachment('/var/tmp/file.tar.gz');               // Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');          // Optional name
                */
                // Content
                
                $emailMsg="Please click on the link below to verify your account:<br><br><a href='http://localhost/unilink/confirm.php?email=$email&token=$token'>Clink Here</a></b>";


                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Verify Email';
                $mail->Body    = $emailMsg;
                $mail->AltBody = strip_tags($emailMsg);

                if($mail->send()){ 
                    echo "Message to $email has been sent";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            /***************************************************************************************************************/
    }
?>