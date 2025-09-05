<?php

// require_once '../vendor/autoload.php';
 require_once __DIR__.'/../base/base.php';
//  require_once __DIR__.'/../setCookie.php';
require_once 'encrypt.php';

function gg_auth($id_token){
    if(!$id_token){
        header("HTTP/1.1 403 Forbidden");
        exit();
    }
    
    $client = new Google_Client(['client_id'=> $_ENV['APP_GOOGLE_CLIENT_ID']]);
    $payload = $client->verifyIdToken($id_token);
    if($payload){
        $user_id = $payload['sub'];
        $email = $payload['email'];
        $name = strtolower($payload['name']);
        $username = str_replace(' ','_',$name);
        return base_checker($email);
        
    
    
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Invalid token"]);
    }
    
}








$class = new Base($_ENV['APP_DB_USERNAME'],$_ENV['APP_DB_PASSWORD'],$_ENV['APP_DB_NAME']);

function base_checker($email){
    global $class;
    $pdo = $class->connect();
    $hash = hash('sha256',$email);
    $stmt = $pdo->prepare("SELECT email,id,username,type FROM users WHERE email_hash=:email_hash");
    $stmt->execute([':email_hash'=>$hash]);
    if($stmt->rowCount()>0){
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data['type']!==2){
            echo json_encode(["error"=>'your account is not a google account!']);
        }
        else{
            $_SESSION['id']= $data['id'];
            $_SESSION['info'] = [
                'username'=>$data['username'],
                'id'=>$data['id']
            ];
            $h_value = hash_hmac('sha256', $email, 'createApi$qkey5784');
                    $_SESSION['userToken_CreateApi'] = $h_value;
            $_SESSION['email'] = $email;
            echo json_encode(["status" => "success", "email" => $email, "username" => $data['username'], 'id'=>$data['id']]);
        }
        
    }
    else{
        $username = username_gen($pdo);
        return add_($email,$username);
    }
    
    
}

function username_gen($pdo){
    do{
        $username = 'user_' . substr(str_shuffle('abcdefjhijklmnopqrstuvwxyzgrhjuwqwcvkureewv'),0,10);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username= ?");
        $stmt->execute([$username]);
        
        $exists = $stmt->fetchColumn();
    }
    while($exists);

    return $username;


}


function  add_($email,$username){
    global $class;
    $pdo = $class->connect();
    $e_email = encrypt($email);
    $hash_email = hash('sha256', $email);
    $stmt = $pdo->prepare("INSERT INTO users (email,username,email_hash,type) 
    VALUES (:email,:username, :hash_email, :type)");
    $stmt->execute([':email'=>$e_email, ':username'=>$username, ":hash_email"=>$hash_email, ":type"=>2]);
    $_SESSION['id']= $pdo->lastInsertId();
    $_SESSION['info'] = [
        'username'=>$username,
        'id'=>$pdo->lastInsertId()
    ];
    $_SESSION['email'] = $email;
    echo json_encode(["status" => "success", "email" => $email, "username" => $username]);

}
?>