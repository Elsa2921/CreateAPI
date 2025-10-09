<?php
 require_once __DIR__.'/../checkers/createApi.php';
include_once 'selectApi.php';


function tablePageReload(){
    $id = $_SESSION['id'] ?? '';
    $info = $_SESSION['info'] ?? '';

    if(!empty($id) and !empty($info)){
        
        $api_id = $_SESSION['api_id'] ?? '';
        if(!empty($api_id)){
            $data = [];
            $checker = tableReload($api_id);
            if(!empty($checker)){
                $data['table'] = $checker;
                $data['info'] = $_SESSION['info'];
                if($checker['type']!== null){
                    $tableData = tableData($checker['type'],$api_id, $id);
                    if(!empty($tableData)){
                        $data['table_data'] = $tableData;
                    }
                    
                }
                echo json_encode(['message'=> $data]);
                
            } 
            else{
                echo json_encode(['message'=> 'no']);
            }  
        }
        else{
            echo json_encode(['message'=> 'no']);
        }
    }
    else{

        echo json_encode(['message'=> 'no']);
    }
}





function delete_line($id,$table){
    $user_id = $_SESSION['id'] ?? '';
    if(!empty($user_id)){
        $checker = selectChecker($table);
        if($checker){
            global $class;
            $class->query("DELETE FROM $table 
            WHERE id=:id",
        ["id"=>$id],2);
    
            echo json_encode(['message'=> 'ok']);
        }
    }
   
    else{
        echo json_encode(['message'=> 'no']);
    }
}


function addLine(){
    $api_id = $_SESSION['api_id'] ?? '';
    $type = $_SESSION['api_type'] ?? '';
    if(!empty($api_id) and !empty($type)){
        global $class;
        $class->query(
            "INSERT INTO $type (api_id) 
            VALUE (:api_id)",
            ['api_id'=>$api_id],2);
        echo json_encode(['message'=> 'ok']);
    }
    else{
        echo json_encode(['error'=> 'something is wrong try later']);
    }
}


function edit_cols($id,$value,$col){
    $type = $_SESSION['api_type'] ?? '';
    if(!empty($type)){
        global $class;
        $class->query("UPDATE $type SET `$col`=:v 
        WHERE id=:id",
    ['v'=>$value,'id'=>$id],2);
        echo json_encode(['message'=> 'ok']);

    }
    else{
        echo json_encode(['error'=> 'something is wrong try later']);
    }
}
?>