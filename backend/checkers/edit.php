<?php
 require_once __DIR__.'/../base/base.php';
// $class = new Base($_ENV['APP_DB_USERNAME'],$_ENV['APP_DB_PASSWORD'],$_ENV['APP_DB_NAME']);



function usernameChecker($username,$id){
    global $class;
    $stmt=  $class->query("SELECT username 
    FROM users 
    WHERE username=:username",
    ['username'=>$username],2);
    $status=  true;
    if($stmt->rowCount()>0){
        $status = false;
    }

    return $status;
}



function passChecker($password,$id){
    global $class;
    $stmt = $class->query("SELECT 
    id,
    password 
    FROM users 
    WHERE id=:id",
    ['id'=>$id],2);
    $status = false;
    if($stmt->rowCount()>0){
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $same=  password_verify($password, $data['password']);
        if($same){
            $status = true;
        }
    }

    return $status;
}
?>