<?php
 require_once __DIR__.'/../checkers/search.php';
 require_once __DIR__.'/../checkers/for_indexx.php';
function user_s($search){
    $id=  $_SESSION['id'] ?? '';
    $get = get_users_s($id,$search);
    $data = [
        'user_search'=>$get
    ];
    echo json_encode($data);
}


function api_s($search){
    $id=  $_SESSION['id'] ?? '';
    $get = get_apis_s($id,$search);
    $data = [
        'api_search'=>$get
    ];
    echo json_encode($data);
}

?>