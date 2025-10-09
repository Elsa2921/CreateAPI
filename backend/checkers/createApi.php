<?php
    require_once __DIR__.'/../base/base.php';

    function getId($name){
        global $class;
        $stmt = $class->query("SELECT id,api_name 
        FROM api_names 
        WHERE api_name=:api_name",
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
        $user_id = $_SESSION['id'] ?? '';
        $data = [];
        if(!empty($user_id)){
            global $class;
            $stmt = $class->query("SELECT 
            an.id,
            an.api_name,
            an.date,
            an.public,
            an.type
             FROM api_names 
            AS an
            INNER JOIN users AS u 
                ON u.id = an.user_id
            WHERE an.id=:id 
                AND an.user_id = :user_id",
            ['id'=>$api_id, ':user_id'=>$user_id],2);
            
            if($stmt->rowCount()>0){
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['api_type'] = $res['type'];
                $data = [
                    'id'=> $res['id'],
                    'api_name'=>$res['api_name'],
                    'type'=>$res['type']
                ];
            }  
        }
        
        return $data;
    }   

    function tableData($type,$api_id,$u_id){
        global $class;
        $stmt = $class->query("SELECT ty.* 
        FROM $type AS ty
        INNER JOIN api_names AS an
            ON an.id = ty.api_id
        WHERE api_id=:api_id
            AND an.user_id = :user_id",
        [
            ':api_id' => $api_id,
            ':user_id' => $u_id
        ],2
    );
        
        $data = [];
        if($stmt->rowCount()>0){
            $data = $stmt->fetchAll();

        }  
        return $data;
    }
?>