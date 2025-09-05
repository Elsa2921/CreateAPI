<?php

require_once __DIR__.'/../vendor/autoload.php';
use Dotenv\Dotenv;
$first = __DIR__;
// $second = __DIR__ . '/register';

if(file_exists($first .'/.env')){
    $dotenv = Dotenv::createImmutable($first);
}
// elseif(file_exists($second .'/.env')){
//     $dotenv = Dotenv::createImmutable($second);
// }
else{
    throw new Exception('.not found .env file');
}
$dotenv->load();
$dotenv->safeLoad();

?>