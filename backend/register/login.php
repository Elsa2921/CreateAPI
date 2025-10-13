<?php
 require_once __DIR__.'/../checkers/register.php';
 require_once __DIR__.'/../setCookie.php';
function login($email,$password,$rememberMe){
    $checker = login_checker($email,$password);
    if($checker){
       
        if($checker=='a'){
            echo json_encode(['error'=>'this account is not created with email, try something else']);
        }
        else{
            $h_value = hash_hmac('sha256', $email, $_ENV['APP_TOKEN_HASH']);
            $_SESSION['userToken_CreateApi'] = $h_value;
            $token = bin2hex(random_bytes(32));          
            $day = 1;
           
            if($rememberMe){
                $day = 30;
                
            }
            $expires = 86400 * $day;
            setDbToken($day,$checker,$token);
            setCookieForUser($token,$expires);
            echo json_encode(['message'=>'ok']);
        }
       
    }
    elseif($checker=='n'){
        echo json_encode(['message'=>'no']);
    }
    else{
        echo json_encode(['error'=>'something is wrong']);
    }
}
?>