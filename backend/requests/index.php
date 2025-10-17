<?php
 require_once __DIR__.'/../pages/link.php';
 $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
 if (!empty($origin)) {
     header("Access-Control-Allow-Origin: $origin");
     header("Access-Control-Allow-Credentials: true");
     header("Access-Control-Allow-Headers: Content-Type");
}



if($_SERVER['REQUEST_METHOD']=='GET' or $_SERVER["REQUEST_METHOD"]=="POST"){
    get_api_name_viaLink($_SERVER["REQUEST_URI"]);
}
else{
    http_response_code(403);
    readfile($_SERVER['DOCUMENT_ROOT'].'/403.html');
}
?>