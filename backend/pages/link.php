<?php
 require_once __DIR__.'/../checkers/link.php';

function get_api_name_viaLink($uri){
    #parse_url
    #parse_str
    $arr = explode('/',$uri);
    $new = $arr[count($arr)-1];
    $a = explode('?',$new);
    $name = $a[0];
    $rest=  0;
    $r_ = [];
    $request = [];
    if(count($a)>1){
        $rest = $a[1];
        $request = explode('&',$rest);
    }
    foreach($request as $value){
        $r_[] = explode('=',$value);
    }
    
    
    // echo json_encode(['m'=>$r_]);

    get_api_viaLink(urldecode($name),$r_);
}
function get_api_viaLink($name,$req){
    $n_checker = name_checker($name);
    $data = [];
    $ff = false;
    if(!empty($n_checker)){
       foreach($req as $v_e){
            if($v_e[0]!=='search' && $v_e[0]!=='page' && $v_e[0]!=='load'){
                $ff = true;
            }
       } 
       if($ff){
            $data = [
                'message'=>'wrong request, check!!',
                'status' => 500,
                'data'=>[]
            ];
       }
       else{
        
            $api = get_api($n_checker['id'],$n_checker['type'],$req);
            $status = 0;
            if(count($api)>0){
                $status = 200;
            }
            else{
                $status = 404;
            }
            $data = [
            'message'=>'ok',
            'status' => $status,
            'total' => count($api),
            'name'=>$name,
            'type'=> $n_checker['type'],
            'data'=>$api
            ];


        }
    }
    elseif($n_checker==23){
        $data = [
            'message'=>'signup or login first in CreateApi and try Again',
            'status' => 500,
            'data'=>[]
        ];
    }
    else{
        $data = [
            'message'=>'error',
            'status' => 500,
            'data'=>[]
        ];
    }
    
    echo json_encode(['data'=>$data]);
}


// print_r(get_api_name_viaLink('http://localhost:8080/backend/requests/link.php/cutegrtjyui'));
?>