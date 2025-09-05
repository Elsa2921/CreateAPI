<?php
 require_once __DIR__.'/../base/base.php';



function api_checker($id){
    global $class;
    $stmt = $class->query("SELECT * FROM api_names WHERE user_id=:user_id",
    ['user_id'=>$id],2);
    $data = [];
    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll());
    }

    if(!empty($data)){
        return get_api_l($data,$id);
    }
    else{
        return $data;
    }
    
}



function get_api_l($data,$id){
    global $class;

    $query = "SELECT token FROM private_apis
    WHERE api_id=:api_id AND user_id=:user_id";
    foreach($data as &$value){
        if(!$value['public']){
            $stmt = $class->query($query,['api_id'=>$value['id'],'user_id'=>$id],2);
            if($stmt->rowCount()>0){
                $t =$stmt->fetchColumn();
                $value['allow'] = 1;
                $value['link_part'] = $t;
            }
        }
    }

    return $data;
}

function get_notif($id){
    global $class;
    $stmt= $class->query("SELECT * FROM notifications WHERE 
    to_=:to_ AND readed=:readed",['to_'=>$id,'readed'=>0],2);
    $flag = [];
    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll());
        $flag = get_names_n($data);
    }
    return $flag;
}


function get_names_n($data){
    global $class;
    $query = "SELECT id,api_name FROM api_names WHERE id=:id";
    foreach($data as &$value){
        unset($value['readed']);
        $stmt=  $class->query($query,['id'=>$value['api_id']],2);
        if($stmt->rowCount()>0){
            $f = $stmt->fetch(PDO::FETCH_ASSOC);
            $value['api_name'] = $f['api_name'];
        }
        else{
            $value['api_name'] = 404;
        }
    }


    return get_usernames_n($data);
    
}


function get_usernames_n($data){
    global $class;
    $query = "SELECT id,username FROM users WHERE id=:id";
    foreach($data as &$value){
        unset($value['to_']);
        $stmt = $class->query($query,['id'=>$value['from_']], 2);
        if($stmt->rowCount()>0){
            $f = $stmt->fetch(PDO::FETCH_ASSOC);
            $value['username'] = $f['username'];
        }
        else{
            $value['username'] = 404;
        }
    }

    return $data;
}

?>