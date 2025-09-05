<?php
 require_once __DIR__.'/../base/base.php';
require_once __DIR__ .'/../register/encrypt.php';
    function id_checker($id){
        global $class;
        $stmt= $class->query("SELECT id, username, email FROM users WHERE id=:id",
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
            $_SESSION['info'] = $flag;
        }
        return $flag;
    }
?>

