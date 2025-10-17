<?php
header("Content-Type: application/json");
 require_once __DIR__.'/../checkers/view.php';
 require_once __DIR__.'/../pages/selectApi.php';
    function view_($id){
        $data = [];
        $get_api = view_get_api($id);
        if(!empty($get_api)){
            $api  = view_getAll($id,$get_api['type']);

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
                'name'=>$get_api['api_name'],
                'type'=> $get_api['type'],
                'data'=>$api
            ];

        }
        else{
            $data = [
                'status'=>'403',
                'data'=>[]
            ];
            // readfile('./create_api/403.html');
        }

        $json = json_encode($data,JSON_PRETTY_PRINT);
        echo $json;
    }




?>