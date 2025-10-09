<?php
 require_once __DIR__.'/../base/base.php';
include_once 'othersApi.php';


function get_apis_s($id,$search){
    global $class;
    $data = [];
    $stmt = '';




    $stmt = $class->query("SELECT 
    an.id,
    an.public,
    an.date,
    an.api_name,
    an.type,
    u.username,
    CASE 
        WHEN pa.user_id IS NOT NULL THEN 1
        ELSE NULL
    END AS allow
    FROM api_names AS an
    INNER JOIN users AS u
        ON u.id = an.user_id 
    LEFT JOIN private_apis AS pa
        ON pa.api_id = an.id
        AND pa.user_id = :user_id_

    WHERE an.user_id!=:user_id 
        AND an.type IS NOT NULL 
        AND an.api_name LIKE :api_name 
    LIMIT 5",
    [
        ':user_id'   =>   $id,
        ':user_id_' =>   $id,
        'api_name' => "%$search%"
    ],2);



    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    return $data;
    
    // return $id;
    // return get_name_($data,$id);
}



function get_users_s($id,$search){
    global $class;
    $data = [];
    $stmt = '';
    if(!empty($id)){
        $stmt = $class->query("SELECT 
        id,
        username 
        FROM users
        WHERE id!=:user_id 
            AND ((password IS NOT NULL AND type!=2) OR type=2)
            AND username LIKE :username 
        LIMIT 5",
       ['user_id'=>$id,'username'=>"%$search%"], 2);

    }
    else{

        $stmt = $class->query("SELECT 
        id,
        username 
        FROM users
        WHERE ((password IS NOT NULL AND type!=2) OR type=2)
            AND username LIKE :username 
        LIMIT 5",
       ['username'=>"%$search%"],2);
    }

    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll());
    }
    


    return $data;
}
?>