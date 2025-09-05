<?php
 require_once __DIR__.'/../base/base.php';


function signup_checker($username,$email){
    global $class;

    $stmt = $class->query("SELECT username FROM users WHERE username=:username",
     ['username'=>$username],2);
    $flag = false;
    if($stmt->rowCount()>0){
        $flag = 'username already exists';
    }
    else{
        $hash = hash('sha256',$email);
        $stmt1 = $class->query("SELECT id,email,username FROM users WHERE email_hash=:email_hash",
        ['email_hash'=>$hash], 2
    );
        if($stmt1->rowCount()>0){
            $flag = 'account already exists with this email';
        }

    }
    
    return $flag;
}


function email_checker($email){
    global $class;
    $hash = hash('sha256',$email);
    $stmt = $class->query("SELECT type FROM users WHERE email_hash=:email_hash",
    [':email_hash'=>$hash], 2);
    $flag = false;
    if($stmt->rowCount()>0){
        $flag = $stmt->fetchColumn();
    }
    return $flag;
}


function code_checker($code){
    global $class;
    $hash = hash('sha256',$_SESSION['email']);
    $stmt = $class->query("SELECT id,email,code FROM users WHERE email_hash=:email_hash",
    ['email_hash'=>$hash],2);
    $flag = false;
    if($stmt->rowCount()>0){
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        if($data['code']==$code){
            $flag = true;
        }
        
    }
    return $flag;
}


function login_checker($email,$password){
    global $class;
    $hash = hash('sha256',$email);
    $stmt = $class->query("SELECT id,email,password,username,type FROM users WHERE email_hash=:email_hash",
    ['email_hash'=>$hash], 2);
    $flag = false;
    if($stmt->rowCount()>0){
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data['type']!==1){
            $flag = 'a';

        }
        else{   
            if(!isset($data['password']) || $data['password'] === NULL || $data['password'] === '') {
                $flag=  'n';
            }
            else{
                if(password_verify($password,$data['password'])){
                    $_SESSION['id']= $data['id'];
                    $_SESSION['info'] = [
                        'username'=>$data['username'],
                        'id'=>$data['id']
                    ];
                    $flag = 'g';
                }
            }
        }
        
        
        
    }
    return $flag;
}
?>