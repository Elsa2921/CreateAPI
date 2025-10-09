<?php
 require_once __DIR__.'/../base/base.php';
 require_once __DIR__.'/../register/encrypt.php';

function getEmailForToken($id){
    global $class;
    $stmt = $class->query("SELECT email 
    FROM users 
    WHERE id=:id",
    [':id'=>$id],2);
    $flag = false;
    if($stmt->rowCount()>0){
        $data = $stmt->fetchColumn();
        $decrypt = decrypt($data);
        $flag  = hash_hmac('sha256', $decrypt, 'createApi$qkey5784');
    }

    return $flag;
}
?>