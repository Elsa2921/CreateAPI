<?php
     require_once __DIR__.'/../checkers/register.php';
    // include_once '../send_mail/mail.php';
    function verification_c($code){
        $checker = code_checker($code);
        if($checker){
            echo json_encode(['message'=>'ok']);
           
        }
        else{
            echo json_encode(['error'=>'wrong code']);
        }
    }
    
?>