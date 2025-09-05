<?php
include_once '../pages/view.php';
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(
        isset($_GET['apiView'])
        and isset($_GET['name'])
        and isset($_GET['type'])
    ){
        view_(urldecode($_GET['name']),$_GET['type']);
    }
    else{
        http_response_code(403);
            readfile($_SERVER['DOCUMENT_ROOT'].'/403.html');
    }
}
else{
    http_response_code(403);
    readfile($_SERVER['DOCUMENT_ROOT'].'/403.html');
}
?>