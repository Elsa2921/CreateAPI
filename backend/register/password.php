<?php
 require_once __DIR__.'/../checkers/register.php';
    function password($password){
        global $class;
        $hash  = password_hash($password,PASSWORD_BCRYPT);
        $class->query("UPDATE users SET password=:password, code=:code WHERE email_hash=:email",
        ['password'=>$hash, 'code'=> 0, "email"=>hash('sha256', $_SESSION['email'])],2);
        echo json_encode(['message'=>'ok']);
    }
?>