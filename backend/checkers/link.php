<?php
 require_once __DIR__.'/../base/base.php';

function name_checker($name){
    global $class;
    $stmt = $class->query("SELECT id,api_name,type,public 
    FROM api_names 
    WHERE api_name=:api_name 
        AND type IS NOT NULL",
    ['api_name'=>$name],2);
    $data = [];
    if($stmt->rowCount()>0){
        $f = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($f['public']){
            $data = $f;
        }
        else{
            $data = get_private_api($f['id'],$f);
        }
    }


    return $data;
}


function returnCookie(){
    return isset($_SESSION['userToken_CreateApi']) ? $_SESSION['userToken_CreateApi'] : '';
}



function get_private_api($id,$f){
    $cookie = returnCookie();
    $data = [];
    if(!empty($cookie)){
        global $class;

        $stmt = $class->query("SELECT * 
        FROM private_apis 
        WHERE token=:token 
            AND api_id=:api_id",
        [':token'=>$cookie, ':api_id'=>$id],2);

        if($stmt->rowCount()>0){
            $data = $f;
        }
    }
    

    return $data;
}


function get_api($id,$type,$req){
    global $class;
    $pdo = $class->connect();
    
    if(!empty($req)){
        $search= false;
        $page = false;
        $load = false;
        foreach($req as $v_e){
            if($v_e[0]=='search'){
                $search = $v_e[1];
            }
            elseif($v_e[0]=='page'){
                $page=$v_e[1];
            }
            else{
                $load=$v_e[1];
            }
        }
        $t = $pdo->query("SHOW COLUMNS FROM $type");
        $columns = $t->fetchAll(PDO::FETCH_COLUMN);
        $col_ = "CONCAT_WS(' ', " . implode(',',$columns) . ")";

        if($search and !$page and !$load){
            $query = "SELECT * FROM $type 
            WHERE api_id=:api_id 
                AND  $col_ LIKE :search";
            $execute = ['api_id'=>$id,':search'=>"%$search%"];
        }
        elseif(!$search and $page and !$load){
            $page1 = $page*10;
            $query = "SELECT * FROM $type 
            WHERE api_id=:api_id 
                AND  $col_  
            LIMIT :limit 
            OFFSET :offset";
            $execute = ['api_id'=>$id, ':limit'=>10, ':offset'=>$page1];
        }
        elseif(!$search and !$page and $load){
            $query = "SELECT * FROM $type 
            WHERE api_id=:api_id 
                AND  $col_  LIMIT :limit";
            $execute = ['api_id'=>$id, ':limit'=>$load];
        }
        elseif($search and $page and !$load){
            $page1 = $page*10;
            $query = "SELECT * FROM $type 
            WHERE api_id=:api_id 
                AND  $col_ LIKE :search  
            LIMIT :limit 
            OFFSET :offset";
            $execute = ['api_id'=>$id,':search'=>"%$search%", 'limit'=>10, ':offset'=>$page1];
        }
        elseif($search and !$page and $load){
            $query = "SELECT * FROM $type 
            WHERE api_id=:api_id 
                AND  $col_ LIKE :search  
            LIMIT :limit";
            $execute = ['api_id'=>$id,':search'=>"%$search%", ':limit'=>$load];
        }
        else{
            $query = "SELECT * FROM $type 
            WHERE api_id=:api_id 
            LIMIT 0";
            $execute = ['api_id'=>$id];
        }
    }
    else{
        $query = "SELECT * FROM $type 
        WHERE api_id=:api_id";
        $execute = ['api_id'=>$id];
        

    }
    


    $stmt = $class->query($query,$execute, 2);
    $data = [];
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