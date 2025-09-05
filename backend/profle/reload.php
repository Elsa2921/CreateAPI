<?php
 require_once __DIR__.'/../checkers/profile.php';
 require_once __DIR__.'/../checkers/for_indexx.php';
 require_once __DIR__.'/../checkers/getUsername.php';
function g_p(){
    $id= $_SESSION['id'] ?? '';
    if(!empty($id)){
        $checker= id_checker($id);
        if($checker){
            $apis = api_checker($id);
            $notif = get_notif($id);
            $data = [
                'user_info'=>$checker,
                'api_data'=>$apis,
                'notif'=> $notif
            ];
            echo json_encode(['message'=> $data]);

        }
        else{
            echo json_encode(['message'=>'no']);
        }
    }
    else{
        echo json_encode(['message'=>'no']);
    }
}



function delete_api($id,$type){
    global $class;
    $class->query("DELETE FROM api_names WHERE id=:id",
['id'=>$id],2);
    if(is_null($type)){
        $class->query("DELETE FROM $type WHERE api_id=:api_id",
    ['api_id'=>$id],2);
        echo json_encode(['message'=>'ok']);
    }
    else{
        echo json_encode(['message'=>'ok']);
    }

    
}


function edit_api($id,$type,$name){
    $_SESSION['api_id'] = $id;
    $_SESSION['api_type'] = $type;
    $_SESSION['api_name'] = $name;
    echo json_encode(['message'=>'ok']);
}


function continue_($id,$name){
    $_SESSION['api_id'] = $id;
    $_SESSION['api_name'] = $name;
    echo json_encode(['message'=>'ok']);
}


function api_status($id,$status){
   global $class;
   $class->query(
    "UPDATE api_names SET public=:public WHERE id=:id",
    ['public'=>$status, 'id'=>$id],2
   );
    echo json_encode(['message'=>'ok']);
}



function edit_username($id,$name){
    global $class;
    $class->query(
        "UPDATE api_names SET api_name=:api_name WHERE id=:id",
        ['api_name'=>$name, 'id'=>$id],2
    );
    echo json_encode(['message'=>'ok']);
}




function read_notif($id){
    global $class;
    $class->query(
        "UPDATE notifications SET readed=:readed WHERE id=:id",
        ['readed'=>1, 'id'=>$id],2
    );
    echo json_encode(['message'=>'ok']);
}


function  allow_notif($id,$api_id,$to){
    $m_id = $_SESSION['id'] ?? '';
    if(!empty($m_id)){
        $getEmail = getEmailForToken($to);
        if($getEmail){
            global $class;
            $class->query(
                "UPDATE notifications SET readed=:readed WHERE id=:id",
                ['readed'=>1, 'id'=>$id],2
            );
            $class->query("INSERT INTO notifications
            (from_, to_, api_id, type_) VALUES 
            (:from_,:to_,:api_id, :type_)",
            ['from_'=>$m_id, 'to_'=>$to, 'api_id'=>$api_id , 'type_'=> 2],1);
            $class->query(
                "INSERT INTO private_apis (user_id,api_id, token) 
                VALUES (:user_id, :api_id, :token)",
                [':user_id'=>$to, ':api_id'=>$api_id, ':token'=>$getEmail],1
            );
            echo json_encode(['message'=>'ok']);
        } 
        else{
            echo json_encode(['message' => 'no']);
        }  
    }
    else{
        echo json_encode(['message' => 'no']);
    }
   
}

function  deny_notif($id,$api_id,$to){
    $m_id = $_SESSION['id'] ?? '';
    if(!empty($m_id)){
        global $class;
        $class->query(
            "UPDATE notifications SET readed=:readed WHERE id=:id",
            ['readed'=>1, 'id'=>$id],2
        );
        $class->query("INSERT INTO notifications
        (from_, to_, api_id, type_) VALUES 
        (:from_,:to_,:api_id, :type_)",
        ['from_'=>$m_id, 'to_'=>$to, 'api_id'=>$api_id , 'type_'=> 3],1);
        echo json_encode(['message'=>'ok'],1);
    }
    else{
        echo json_encode(['message' => 'no']);
    }
   
}


function all_read(){
    $id = $_SESSION['id'] ?? '';
    if(!empty($id)){
        global $class;
        $class->query(
            "UPDATE notifications SET readed=:readed WHERE to_=:to_ AND type_!=:type_",
            ['readed'=>1, 'to_'=>$id, 'type_'=>1],2
        );

        echo json_encode(['message'=>'ok']);
    }
    else{
        echo json_encode(['message' => 'no']);
    }
}
?>