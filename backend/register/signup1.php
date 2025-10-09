<?php
 require_once __DIR__.'/../checkers/register.php';
 require_once __DIR__.'/../send_mail/mail.php';
include_once 'encrypt.php';
    function signup($username,$email){
        $checker=  signup_checker($username,$email);
        if($checker){
            echo json_encode(['error'=>$checker]);
        }
        else{
            global $class;
            $code = code();
            $e_email = encrypt($email);
            $hash_email = hash('sha256', $email);
            $class->query("INSERT INTO users 
            (username,email,code,email_hash,type) 
            VALUES (:username,:email,:code, :hash_email, :type)",
            [
                ":username"=>$username,
                ":email"=>$e_email,
                ':code'=>$code, 
                ":hash_email"=>$hash_email, 
                ":type"=>1],1
        );
            code_mailer($code,$email);
            $_SESSION['email'] = $email;
            
            echo json_encode(['message'=>'ok']);
        }
    }
?>