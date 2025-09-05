<?php
require_once __DIR__. '/../base/base.php';


// function get_apis($a,$id){
//     global $class;
//     $pdo = $class->connect();
//     $data = [];
//     $flag = false;
//     $stmt = '';
//     if(!empty($id)){
//         if(!$a){
//             $stmt = $pdo->prepare("SELECT * FROM api_names
//             WHERE user_id!=:user_id AND type IS NOT NULL");
//             $stmt->execute(['user_id'=>$id]);
//         }
//         else{
//             $flag = true;
//         }
//     }
//     else{
//         if(!$a){
//             $stmt = $pdo->prepare("SELECT * FROM api_names
//              WHERE type IS NOT NULL");
//             $stmt->execute();
//         }
//         else{
//             $flag = true;
//         }
//     }

//     if($flag){
//         $stmt = $pdo->prepare("SELECT * FROM api_names WHERE
//          user_id=:user_id AND type IS NOT NULL");
//         $stmt->execute(['user_id'=>$a]);
//     }

//     if($stmt->rowCount()>0){
//         $data = array_reverse($stmt->fetchAll());
//     }
    


//     return get_name_($data,$id);
// }



function get_apis($a,$id,$limit,$type){
    global $class;
    $data = [];
    $flag = false;
    $stmt = '';
    if(!empty($id)){
        if($a){
            $flag = true;
           
        }

    }
    else{
        if($a){
            $flag = true;
        }
    }

    if($flag){
        $stmt = $class->query("SELECT * FROM api_names WHERE
         user_id=:user_id AND type IS NOT NULL",['user_id'=>$a],2);
    }
    else{
        $stmt = $class->query("SELECT * FROM api_names
        WHERE user_id!=:user_id AND public=:public AND type IS NOT NULL LIMIT :limit ",
        ['user_id'=>$id,'limit'=>$limit,':public'=>$type],2);
    }
    if($stmt->rowCount()>0){
        $data = array_reverse($stmt->fetchAll());
    }
    

    return get_name_($data,$id);
}


    function get_name_($data,$id){
        global $class;
        $query = "SELECT id,username FROM users WHERE id=:id";
        foreach($data as &$value){
            $value['username'] = '404';
            $stmt = $class->query($query,['id'=>$value['user_id']],2);
            if($stmt->rowCount()>0){
                $d = $stmt->fetch(PDO::FETCH_ASSOC);
                $value['username'] = $d['username'];
            }
            unset($value['user_id']);
        }

        if(!empty($id)){
            return get_api_notif($data,$id);
        }

        else{
            return $data;
        }
        
    }

    function api_id_checker($id){
        global $class;
        $flag = false;
        $stmt = $class->query("SELECT * FROM api_names WHERE id=:id",
        ['id'=>$id],2);
        if($stmt->rowCount()>0){
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $flag = $r['user_id'];
        }

        return $flag;
    }

    function visit_id_checker($id){
        global $class;
        $flag = false;
        $stmt = $class->query("SELECT * FROM users WHERE id=:id",
        ['id'=>$id],2);
        if($stmt->rowCount()>0){
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $flag = [
                'id'=>$r['id'],
                'username'=>$r['username']
            ];
        }

        return $flag;
    }


    function get_api_notif($data,$id){
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
?>