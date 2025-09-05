<?php
 require_once __DIR__.'/../checkers/createApi.php';
function api_name($name){
    $id = $_SESSION['id'] ?? '';
    if(!empty($id)){
        $checker = apiNameChecker($name);
        if($checker){
            $_SESSION['apiName'] = $name;
            global $class;
            $class->query("INSERT INTO api_names (user_id,api_name) VALUES (:user_id,:api_name)",
        ['user_id'=>$id, 'api_name'=>$name],1);
            echo json_encode(['message'=>'ok']);
        }
        else{
            echo json_encode(['error'=>'this api name already exists']);
        }
    }
    else{
        echo json_encode(['message'=>'no']);
    }
    
}



?>