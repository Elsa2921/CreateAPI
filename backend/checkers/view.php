<?php
 require_once __DIR__.'/../base/base.php';

function view_get_api($name,$type){
    global $class;
    $stmt = $class->query("SELECT * FROM api_names 
    WHERE api_name=:api_name 
    AND type=:type",
    ['api_name'=>$name, 'type'=>$type],2);

    $id=  false;
    $data=  [];
    if($stmt->rowCount()>0){
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        $id=$data['id'];
    }

    return $id;
    
}



function view_getAll($id,$type){
    global $class;
    $stmt = $class->query("SELECT * FROM $type 
    WHERE api_id=:api_id",
    ['api_id' => $id],2);
    $data =[];
    if($stmt->rowCount()>0){
        $id = 0;
        $data = $stmt->fetchAll();
        foreach($data as &$value){
            $id++;
            unset($value['api_id']);
            $value['id'] = $id;
            
        }
    }

    return $data;
}
?>