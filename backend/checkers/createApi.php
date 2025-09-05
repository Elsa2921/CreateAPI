<?php
    require_once __DIR__.'/../base/base.php';
        
    function apiNameChecker($name){
        global $class;
        $stmt = $class->query("SELECT api_name FROM api_names WHERE api_name=:api_name",
        ['api_name'=>$name],2);
        $flag = true;
        if($stmt->rowCount()>0){
            $flag = false;
        }   
        return $flag;
    }


    function getId($name){
        global $class;
        $stmt = $class->query("SELECT id,api_name FROM api_names WHERE api_name=:api_name",
        ['api_name'=>$name],2);
        $id = 0;
        if($stmt->rowCount()>0){
           $data = $stmt->fetch(PDO::FETCH_ASSOC);
           $_SESSION['api_id'] = $data['id'];
           $id=$data['id'];
        }   
        return $id;
    }


    function tableReload($api_id){
        global $class;
        $stmt = $class->query("SELECT * FROM api_names WHERE id=:id",
        ['id'=>$api_id],2);
        $data = [];
        if($stmt->rowCount()>0){
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['api_type'] = $res['type'];
            $data = [
                'id'=> $res['id'],
                'api_name'=>$res['api_name'],
                'type'=>$res['type']
            ];
        }  
        return $data;
    }   

    function tableData($type,$api_id){
        global $class;
        $stmt = $class->query("SELECT * FROM $type WHERE api_id=:api_id",
        ['api_id'=>$api_id],2
    );
        
        $data = [];
        if($stmt->rowCount()>0){
            $data = $stmt->fetchAll();

        }  
        return $data;
    }
?>