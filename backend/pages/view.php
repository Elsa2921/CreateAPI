<?php
header("Content-Type: application/json");
 require_once __DIR__.'/../checkers/view.php';
 require_once __DIR__.'/../pages/selectApi.php';
    function view_($name,$type){
        $typeChecker = selectChecker($type);
        $data = [];
        if($typeChecker){
            $get_api = view_get_api($name,$type);
            if($get_api){
                $api  = view_getAll($get_api,$type);
                
                // if(!empty($api)){
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
                      'type'=> $type,
                      'data'=>$api
                    ];
            }
            else{
                $data = [
                    'message'=>'error',
                    'status' => 500,
                    'data'=>[]
                ];
            }
        }
        else{
            http_response_code(403);
            readfile('create_api/403.html');
        }

        $json = json_encode($data,JSON_PRETTY_PRINT);
        echo $json;
    }




?>