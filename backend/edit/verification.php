<?php
 require_once __DIR__.'/../checkers/edit.php';
 require_once __DIR__ .'/../register/encrypt.php';
//  require_once __DIR__.'/../setCookie.php';
function verification_n($code){
    $email = $_SESSION['edit_email'] ?? '';
    $code1 = $_SESSION['edit_code'] ?? '';
    $id = $_SESSION['id'] ?? '';
    if(!empty($id)){

        if(!empty($email) and !empty($code1)){
            if($code==$code1){
                global $class;
                $e_email = encrypt($email);
                $hash_email = hash('sha256', $email);
                $class->query("UPDATE users SET email=:email,email_hash=:hash WHERE id=:id",
                ['email'=>$e_email,':hash'=>$hash_email,'id'=>$id],2);
                $_SESSION['info']['email'] = $email;
                update_apiTokens($id,$email);
                unset($_SESSION['edit_email']);
                unset($_SESSION['edit_code']);

                $h_value = hash_hmac('sha256', $email, 'createApi$qkey5784');
                $_SESSION['userToken_CreateApi'] = $h_value;
                // setCookieForUser($email);

                
               
                echo json_encode(['message'=>'ok']);
                
            }
            else{
                echo json_encode(['error'=>'wrong code']);
            }
        }
        else{
            echo json_encode(['error'=>'nice try but something is wrong!!']);
        }
    }
    else{
        echo json_encode(['error'=>'you are not allowed to make changes when you arent in your acc']);
    }
}


function update_apiTokens($id,$value){
    global $class;
    $h_value = hash_hmac('sha256', $value, 'createApi$qkey5784');
    $class->query("UPDATE private_apis SET token=:token WHERE user_id=:user_id",
[':token'=>$h_value, ':user_id'=>$id],2);
}
?>