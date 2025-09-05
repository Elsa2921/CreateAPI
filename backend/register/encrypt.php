<?php
    require_once 'use.php';


    define('ENCRYPTION_KEY',hash('sha256',$_ENV['APP_ENCRYPTION_KEY']));
 function encrypt($email){
    
    $iv = openssl_random_pseudo_bytes(16);
    $m = "AES-256-CBC";
    $encrypt_ = openssl_encrypt($email,$m,
    ENCRYPTION_KEY,OPENSSL_RAW_DATA, $iv);
    $data = base64_encode($iv . $encrypt_);
    return $data;
}


function decrypt($email){
    
    $decrypt = base64_decode($email);
    $iv = substr($decrypt, 0, 16);
    $e = substr($decrypt,16);
    $d = openssl_decrypt($e,'AES-256-CBC',ENCRYPTION_KEY,OPENSSL_RAW_DATA,$iv);
    return $d;
}
?>