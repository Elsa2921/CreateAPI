<?php

use Google\Service\CloudDeploy\Rollback;
session_start();
require_once __DIR__.'/../register/use.php';
class Base{
    public $host= 'localhost';
    protected $username;
    protected $pass;
    protected $db_name;
    private $pdo;
    public function __construct($username,$pass,$db_name){
        $this->username = $username;
        $this->pass = $pass;
        $this->db_name = $db_name;
    }


    public function connect(){
        try{
           if($this->pdo === NULL){
                $this->pdo =  new PDO("mysql:host=$this->host; dbname=$this->db_name; charset=utf8mb4"
                ,$this->username, $this->pass,[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
           }
           return $this->pdo;
            
        }catch(PDOException $e){
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function commit(){
        if($this->pdo && $this->pdo->inTransaction()){
            $this->pdo->commit();
        }
    }


    public function beginTransaction(){
        return $this->connect()->beginTransaction();
    }


    public function rollBack(){
        if($this->pdo && $this->pdo->inTransaction()){
            $this->pdo->rollBack();
        }
    }

    public function query($prepare,$execute = [],$type){
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