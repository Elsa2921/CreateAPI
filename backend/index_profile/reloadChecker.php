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
            if(isset($_COOKIE['remember_me'])){
                $checker = token_checker($_COOKIE['remember_me']);
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
    }
?>