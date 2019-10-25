<?php
    function Token($tokenLength = 10)
    {
        $token= "qwertzuiopasdfghjklyxcvbnm1234567890QWERTZUIOPASDFGHJKLYXCVBNM!#$%&/()*+_";
        $token= str_shuffle($token);
        $token= substr($token, 0,$tokenLength);

        return $token;
    }
?>