<?php
 require_once __DIR__.'/../checkers/createApi.php';


function select($type){
    $name =  $_SESSION['apiName'] ?? '';
    
    $cookie = $_SESSION['userToken_CreateApi']?? '';
    $user_id = $_SESSION['id'] ?? '';
    if(!empty($name) and !empty($cookie) and !empty($user_id)){
        
        $checker = selectChecker($type);
        if($checker){
            $id= getId($name);
            global $class;
            try{
                $class->beginTransaction();
                $class->query(
                    "UPDATE api_names SET type=:type
                    WHERE api_name=:api_name 
                        AND user_id = :user_id",
                    [
                        ":type"=>$type,
                        ":api_name"=>$name, 
                        ':user_id' => $user_id],2);
    
                $class->query(
                    "INSERT INTO $type (api_id) 
                    VALUE (:api_id)",
                    [':api_id'=>$id],1);
    
                $class->query("INSERT INTO private_apis 
                    (user_id, api_id, token) 
                    VALUES(:user_id, :api_id, :token)", 
                [
                    ':user_id'=>$user_id, 
                    ':api_id'=>$id, 
                    ':token' => $cookie],1);

                $class->commit();
                echo json_encode(['message'=>'ok']);
            }
            catch (Exception $e){
                $class->rollBack();
                throw $e;
                // echo json_encode(['error'=>'something is wrong']);


            }
        }
        else{
            echo json_encode(['error'=>'something is wrong']);
        }

    }
    else{
        echo json_encode(['error'=> 'something is wrong try later!!']);
    }
}




$types = [
    'users_api',
    'tasks',
    'notifications_api',
    'products',
    'movies',
    'podcast',
    'blog',
    'weather',
    'programmin_l',
    'comments',
    'books',
    'quiz',
    'calendar',
    'workout',
    'flight'
];


function selectChecker($type){
    global $types;
    $flag = false;
    foreach($types as $i){
        if($i==$type){
            $flag = true;
            break;
        }
    }
    return $flag;
}



?>