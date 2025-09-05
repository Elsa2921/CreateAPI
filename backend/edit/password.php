<?php
 require_once __DIR__.'/../checkers/edit.php';


function passwordChecker($password){
    $id = $_SESSION['id'] ?? '';
    if(!empty($id)){
       $checker =  passChecker($password,$id);
       if($checker){
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