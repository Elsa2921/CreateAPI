<?php

use Google\Service\CloudDeploy\Rollback;
session_start();
require_once __DIR__.'/../register/use.php';
class Base{
    public $host= 'localhost';
    protected $username;
    protected $pass;
    protected $db_name;
    public function __construct($username,$pass,$db_name){
        $this->username = $username;
        $this->pass = $pass;
        $this->db_name = $db_name;
    }


    public function connect(){
        try{
           
            return new PDO("mysql:host=$this->host; dbname=$this->db_name; charset=utf8mb4"
            ,$this->username, $this->pass,[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        }catch(PDOException $e){
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function commit(){
        $pdo = $this->connect();
        return $pdo->commit();
    }


    public function beginTransaction(){
        $pdo = $this->connect();
        return $pdo->beginTransaction();
    }


    public function rollBack(){
        $pdo = $this->connect();
        return $pdo->rollBack();
    }

    public function query($prepare,$execute,$type){
        $pdo = $this->connect();
        $stmt = $pdo->prepare($prepare);
        $stmt->execute($execute);
        $data = false;
        $data = ($type==1)? $pdo->lastInsertId() : $stmt;
        return $data;
    }

}

$class = new Base($_ENV['APP_DB_USERNAME'],$_ENV['APP_DB_PASSWORD'],$_ENV['APP_DB_NAME']);
?>