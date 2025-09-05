<?php
require_once __DIR__. '/../register/use.php';

    
 

 
function code_mailer($code,$email){
    $fromEmail = $_ENV['APP_MAIL_FROM'];
    $to = $email;
    $subject = "Validation Email";

    $headers  = "From: $fromEmail\r\n";
    $headers .= "Reply-To: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $message = "
        <html>
        <body>
            <p>Hello from <b>CreateAPI</b>.</p>
            <p>This is a verification email for your account.</p>
            <p>Please use the code below to verify your email:</p>
            <p style='font-size: 18px; font-weight: bold; letter-spacing: 2px;'>$code</p>

        </body>
        </html>
    ";
    // if (mail($to, $subject, $message, $headers)) {
    //     return true;
    // } else {
    //     return false;
    // }
}


function code_mailer_new($code,$email){
    $fromEmail = $_ENV['APP_MAIL_FROM'];
    $to = $email;
    $subject = "Validation Email";

    $headers  = "From: $fromEmail\r\n";
    $headers .= "Reply-To: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $message = "
        <html>
        <body>
            <p>Hello from <b>CreateAPI</b>.</p>
            <p>This is a verification code for changing email.</p>
            <p>Please use the code below to verify your email:</p>
            <p style='font-size: 18px; font-weight: bold; letter-spacing: 2px;'>$code</p>

        </body>
        </html>
    ";
    // if (mail($to, $subject, $message, $headers)) {
    //     return true;
    // } else {
    //     return false;
    // }
}

function code(){
    return rand(100000,999999);
}


function mail_toDev($email,$message){
    $fromEmail = $email;
    $to = $_ENV['APP_MAIL_FROM'];
    $subject = "Contact email";

    $headers  = "From: $fromEmail\r\n";
    $headers .= "Reply-To: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $message = "
        <html>
        <body>
            <p>Hello from <b>CreateAPI</b>.</p>
            <p>This is a message to Developer.</p>
            <p style='font-size: 18px; font-weight: bold; letter-spacing: 2px;'>$message</p>

        </body>
        </html>
    ";
    // if (mail($to, $subject, $message, $headers)) {
    //     return true;
    // } else {
    //     return false;
    // }

}
?>