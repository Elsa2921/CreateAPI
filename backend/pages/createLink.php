<?php

function createLink(){
    $protocol = (!empty($_SERVER["HTTPS"])) && $_SERVER["HTTPS"] !== 'off' ? 'https' : 'http';
    $host = $_SERVER["HTTP_HOST"];
    $fullLink = $protocol."://".$host.'/backend/requests/link.php/';
    echo json_encode($fullLink);
}
?>