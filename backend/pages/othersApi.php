<?php
 require_once __DIR__.'/../checkers/othersApi.php';
 require_once __DIR__.'/../checkers/for_indexx.php';




 function getOthers_api($p,$limit,$type){
    $id= $_SESSION['id'] ?? '';
    $i = $_SESSION['s_visit'] ?? false;
    if($p==="true"){
        $get= get_apis($i['id'],$id,$limit,'');
    }
    else{

        $get= get_apis(false,$id,$limit,$type);
        if($i){
            unset($_SESSION['s_visit']);
        }
    }
    $data = [];
    $data = [
        'api_info'=>$get
    ];
    if(!empty($i)){
        $data['u'] = $i['username'];
    }
    echo json_encode(['message'=>$data]);
}








function ask_permission($id){
    $u = $_SESSION['id'] ?? '';
    if(!empty($u)){
        $checker= api_id_checker($id);
        if($checker){
            global $class;
            $class->query(
                "INSERT INTO notifications 
                (from_,to_,api_id,type_) 
                VALUES (:from_,:to_,:api_id,:type_)",
        ['from_'=>$u, 'to_'=> $checker, 'api_id'=>$id, 'type_'=>'1'],1);
            echo json_encode(['message'=>'ok']);
        }
        else{
            echo json_encode(['error'=>'you cannot ask a permission, try later']);
        }
    }
    else{
        echo json_encode(['error'=>'please sign in first']);
    }
    
}


function visit_p($id){
    $checker = visit_id_checker($id);
    if($checker){
        $_SESSION['s_visit'] = $checker;
        echo json_encode(['message'=>'ok']);
    }
    else{
        echo json_encode(['message'=>'no']);
    }
}
?>