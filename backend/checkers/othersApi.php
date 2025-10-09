<?php
require_once __DIR__. '/../base/base.php';

    function get_apis($a,$id,$limit,$type){
        global $class;
        $data = [];
        $stmt = '';
        if($a){
            $stmt = $class->query("SELECT * FROM api_names 
            WHERE user_id=:user_id 
                AND type IS NOT NULL",
                ['user_id'=>$a],2);
           
        }
        else{
            $stmt = $class->query("SELECT 
            an.id,
            an.public,
            an.date,
            an.api_name,
            an.type,
            u.username,
            CASE 
                WHEN pa.user_id IS NOT NULL THEN 1
                ELSE NULL
            END AS allow
            FROM api_names AS an
            INNER JOIN users AS u
                ON u.id = an.user_id 
            LEFT JOIN private_apis AS pa
                ON pa.api_id = an.id
                AND pa.user_id = :user_id_
            WHERE an.user_id!=:user_id 
                AND an.public=:public 
                AND an.type IS NOT NULL 
            LIMIT :limit ",
            [
                ':user_id'   =>   $id,
                ':limit'     =>   $limit,
                ':public'   =>   $type,
                ':user_id_' =>   $id
            ],2);
        }
    
        if($stmt->rowCount()>0){
            $data = array_reverse($stmt->fetchAll());
        }
        
        return $data;
    }
    

    


    function api_id_checker($id){
        global $class;
        $flag = false;
        $stmt = $class->query("SELECT * 
        FROM api_names 
        WHERE id=:id",
        ['id'=>$id],2);
        if($stmt->rowCount()>0){
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $flag = $r['user_id'];
        }

        return $flag;
    }

    function visit_id_checker($id){
        global $class;
        $flag = false;
        $stmt = $class->query("SELECT * 
        FROM users 
        WHERE id=:id",
        ['id'=>$id],2);
        if($stmt->rowCount()>0){
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            $flag = [
                'id'=>$r['id'],
                'username'=>$r['username']
            ];
        }

        return $flag;
    }

?>