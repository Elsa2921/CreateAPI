<?php

 require_once __DIR__.'/../checkers/edit.php';

function editUsername($username){
    $id = $_SESSION['id'] ?? '';
    if(!empty($id)){
       $checker =  usernameChecker($username,$id);
       if($checker){
        global $class;
        $class->query("UPDATE users 
        SET username= :username 
        WHERE id=:id",
        ["username"=>$username, "id"=>$id],2);
        $_SESSION['info']['username'] = $username;
        
        echo json_encode(['message'=>'ok']);
       }
       else{
            echo json_encode(['message'=>'no']);
       }
    }
    else{
        echo json_encode(['error'=>'no']);
    }

}
?>