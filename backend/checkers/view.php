<?php
 require_once __DIR__.'/../base/base.php';

function view_get_api($id){
    global $class;
    $stmt = $class->query("SELECT 
    * FROM api_names AS an
    WHERE an.id=:api_id",
    ['api_id'=>$id],2);

    $data=  [];
    $return = [];
    if($stmt->rowCount()>0){
        $data= $stmt->fetch(PDO::FETCH_ASSOC);
        $return['api_name'] = $data['api_name'];
        $return['type'] = $data['type'];
    }

    return $return;
    
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