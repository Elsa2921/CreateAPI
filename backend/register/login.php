<?php
 require_once __DIR__.'/../checkers/register.php';
function login($email,$password){
    $checker = login_checker($email,$password);
    if($checker){
        if($checker)
            if($checker=='g'){
                $h_value = hash_hmac('sha256', $email, 'createApi$qkey5784');
                $_SESSION['userToken_CreateApi'] = $h_value;
                // setCookieForUser($email);
                echo json_encode(['message'=>'ok']);
            }
            elseif($checker=='a'){
                echo json_encode(['error'=>'this account is not created with email, try something else']);
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