<?php
 require_once __DIR__.'/../checkers/for_indexx.php';

    function reloadChecker(){
        $id= $_SESSION['id'] ?? '';
        if(!empty($id)){
            $checker= id_checker($id);
            if($checker){
                echo json_encode(['message'=>$checker]);
            }
            else{
                echo json_encode(['message'=>'no']);
            }
        }
        else{
            echo json_encode(['message'=>'no']);
        }
    }
?>