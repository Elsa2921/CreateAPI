<?php
 require_once __DIR__.'/../base/base.php';
require_once __DIR__ .'/../register/encrypt.php';
require_once __DIR__."/../setCookie.php";
    function id_checker($id){
        global $class;
        $stmt= $class->query("SELECT id, username, email 
        FROM users 
        WHERE id=:id",
        ['id'=>$id],2);
        $flag = false;
        if($stmt->rowCount()>0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = decrypt($data['email']);
            $flag=  [
                'id'=>$data['id'],
                'username'=>$data['username'],
                'email'=>$email
            ];
            setSession($flag,$id);
        }
        return $flag;
    }

    // 

    function token_checker($token){
        global $class;
        $dt = new DateTime();
        $now = $dt->format("Y-m-d H:i:s");
        $stmt = $class->query("SELECT id, username, email 
        FROM users 
        WHERE token=:token 
            AND exp_date>:now_",
    ['token'=>$token,'now_'=>$now],2);
    $flag = false;
       if($stmt->rowCount()>0){
        $data=  $stmt->fetch();
        $email = decrypt($data['email']);
        $flag=  [
            'id'=>$data['id'],
            'username'=>$data['username'],
            'email'=>$email

            
        ];
        setSession($flag,$data['id']);

        
       }
       return $flag;

    }
?>

