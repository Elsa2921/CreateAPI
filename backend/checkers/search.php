<?php
 require_once __DIR__.'/../base/base.php';
include_once 'othersApi.php';


function get_apis_s($id,$search){
    global $class;
    $data = [];
    $stmt = '';


    $stmt = $class->query(
        "SELECT * FROM api_names
         WHERE type IS NOT NULL
         AND user_id != :user_id
         AND api_name LIKE :api_name LIMIT 5",
        ['user_id' => $id, 'api_name' => "%$search%"],
        2
    );


    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    
    // return $id;
    return get_name_($data,$id);
}



function get_users_s($id,$search){
    global $class;
    $data = [];
    $stmt = '';
    if(!empty($id)){
        $stmt = $class->query("SELECT id,username FROM users
        WHERE id!=:user_id 
        AND ((password IS NOT NULL AND type!=2) OR type=2)
        AND username LIKE :username LIMIT 5",
       ['user_id'=>$id,'username'=>"%$search%"], 2);

    }
    else{

        $stmt = $class->query("SELECT id,username FROM users
        WHERE ((password IS NOT NULL AND type!=2) OR type=2)
        AND username LIKE :username LIMIT 5",
       ['username'=>"%$search%"],2);
    }

    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll());
    }
    


    return $data;
}
?>