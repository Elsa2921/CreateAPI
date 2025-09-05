<?php
 require_once __DIR__.'/../checkers/register.php';
 require_once __DIR__.'/../send_mail/mail.php';

function email($email,$type){
    $checker = email_checker($email);
    if($type==1){
        if($checker){
            if($checker!==1){
                echo json_encode(['error'=>'this account is not created with email']);
            }   
            else{
                $_SESSION['email'] = $email;
                $code = code();
                code_mailer($code,$email);
                global $class;
                $hash_email = hash('sha256', $email);
                $class->query("UPDATE users SET code=:code WHERE email_hash=:email",
                ['email'=>$hash_email, 'code'=>$code],2
                );
                echo json_encode(['message'=>'ok']);
            }
            
        }
        else{
            echo json_encode(['error'=>'account does not exist with this email']);
        }
        
    }
    elseif($type==2){
        if(!$checker){ 
            $code = code();
            $_SESSION['edit_email'] = $email;
            $_SESSION['edit_code'] = $code;
            
            code_mailer_new($code,$email);
            echo json_encode(['message'=>'ok']);
        }
        else{
            echo json_encode(['error'=>'account already exists with this email']);
        }
        
    }
}



function new_code_n(){
    $email = $_SESSION['edit_email'] ?? '';
    if(!empty($email)){
        $code = code();
        code_mailer_new($code,$email);
        $_SESSION['edit_code'] = $code;
        echo json_encode(['message'=>'ok']);
        
    }
    else{
        echo json_encode(['error'=>'problem with email']);
    }

    
}

function new_code(){
    $email = $_SESSION['email'] ?? '';
    if(!empty($email)){
        global $class;
        $code = code();
        $hash_email = hash('sha256', $email);
        code_mailer($code,$email);
        $class->query("UPDATE users SET code=:code WHERE email_hash=:email",
            ['code'=>$code ,'email'=>hash('sha256', $email)],2
        );
        echo json_encode(['message'=>'ok']);
        
    }
    else{
        echo json_encode(['error'=>'problem with email']);
    }

    
}




?>