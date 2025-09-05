<?php
// session_set_cookie_params([
//     'secure' => true,      
//     'httponly' => true,
//     'samesite' => 'None'    
// ]);


require_once __DIR__.'/register/signup1.php';
require_once __DIR__.'/register/email.php';
require_once __DIR__.'/register/verification.php';
require_once __DIR__.'/register/password.php';
require_once __DIR__.'/register/login.php';
require_once __DIR__.'/edit/editUsername.php';
require_once __DIR__.'/edit/password.php';
require_once __DIR__.'/edit/verification.php';
require_once __DIR__.'/index_profile/reloadChecker.php';
require_once __DIR__.'/send_mail/mail.php';
require_once __DIR__.'/register/google-auth.php';
require_once __DIR__.'/pages/apiName.php';
require_once __DIR__.'/pages/selectApi.php';
require_once __DIR__.'/pages/table.php';
require_once __DIR__.'/pages/othersApi.php';
require_once __DIR__.'/pages/createLink.php';
require_once __DIR__.'/profle/reload.php';
require_once __DIR__.'/checkers/createApi.php';
require_once __DIR__.'/pages/view.php';
require_once __DIR__. '/pages/search.php';
require_once __DIR__. '/profle/logout.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $post = json_decode(file_get_contents('php://input'),true);
    if(
        isset($post['signup1'])
        and isset($post['username'])
        and isset($post['email'])
    ){
        if(!empty($post['username']) and !empty($post['email'])){
            signup($post['username'],$post['email']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }
    elseif(
        isset($post['email1'])
        and isset($post['email'])
    ){
        if(!empty($post['email'])){
            email($post['email'],1);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }
    elseif(
        isset($post['verification'])
        and isset($post['code'])
        and isset($post['type'])
    ){
        if(!empty($post['code'])){
            if($post['type']=='1'){
                verification_c($post['code']);
            }
            elseif($post['type']=='2'){
                verification_n($post['code']);
            }
            else{
                echo json_encode(['error'=>'n']);
            }
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }
    elseif(
        isset($post['password'])
        and isset($post['c_password'])
    ){
        if(
            !empty($post['password'])
            and !empty($post['c_password'])
        ){
            password($post['password']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }
    elseif(
        isset($post['new_code'])
        and isset($post['type'])
        ){
        if($post['type']=='1'){
            new_code();
        }
        elseif($post['type']=='2'){
            new_code_n();
        }
        else{
            echo json_encode(['error'=>'n']);
        }
        
    }

    elseif(
        isset($post['login'])
        and isset($post['email'])
        and isset($post['password'])
    ){
        if(
            !empty($post['email'])
            and !empty($post['password'])
        ){
            
            login($post['email'],$post['password']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(isset($post['id_token']) and isset($post['google_auth'])){
        gg_auth($post['id_token']);
    }

    elseif(
        isset($post['new'])
        and isset($post['api_name'])
    ){
        if(!empty($post['api_name'])){
           api_name($post['api_name']);
        }
        else{
            echo json_encode(['error'=>'no']);
        }
    }

    elseif(
        isset($post['apiType'])
        and isset($post['type'])
    ){
        if(!empty($post['type'])){
            select($post['type']);
        }
        else{
            echo json_encode(['error'=> 'select one of the options']);
        }
    }

    elseif(isset($post['addLine'])){
        addLine();
    }

    elseif(
        isset($post['email'])
        and isset($post['message'])
        and isset($post['messageToDev'])
    ){
        if(
            !empty($post['email'])
            and !empty($post['message'])
        ){
            mail_toDev($post['email'],$post['message']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(
        isset($post['all_read_notif'])
    ){
        all_read();
    }

    elseif(
        isset($post['allow_notif'])
        and isset($post['id'])
        and isset($post['api_id'])
        and isset($post['from'])
    ){
        if(
            !empty($post['id'])
            and !empty($post['api_id'])
            and !empty($post['from'])
            ){
            allow_notif($post['id'],$post['api_id'],$post['from']);
            
        }
        else{
            echo json_encode(['message'=>'no']);

        }
    }

    elseif(
        isset($post['deny_notif'])
        and isset($post['id'])
        and isset($post['api_id'])
        and isset($post['from'])
    ){
        if(
            !empty($post['id'])
            and !empty($post['api_id'])
            and !empty($post['from'])
            ){
            deny_notif($post['id'],$post['api_id'],$post['from']);
            
        }
        else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(
        isset($post['read_notif'])
        and isset($post['id'])
    ){
        if(!empty($post['id'])){
            read_notif($post['id']);
            
        }
        else{
            echo json_encode(['message'=>'no']);

        }
    }
}


elseif($_SERVER["REQUEST_METHOD"]==='GET'){
    if(isset($_GET['PageReload'])){
        reloadChecker();
    }

    elseif(
        isset($_GET['reload1'])
        and isset($_GET['profile'])
    ){
        g_p();
    }

    elseif(
        isset($_GET['reload1'])
        and isset($_GET['table'])
    ){
        tablePageReload();
    }

    elseif(
        isset($_GET['others_api'])
        and isset($_GET['Oprofile'])
        and isset($_GET['Oreload'])
        and isset($_GET['loadApis'])
        and isset($_GET['type'])
    ){
        getOthers_api($_GET['Oprofile'],$_GET['loadApis'],$_GET['type']);
       
    }

    elseif(
        isset($_GET['visit'])
        and isset($_GET['id'])
    ){
        if(!empty($_GET['id'])){
            visit_p($_GET['id']);
        }
        else{
            echo json_encode(['message'=>'no']);
        }
    }

    elseif(
        isset($_GET['ask_permission'])
        and isset($_GET['id'])
    ){
        if(!empty($_GET['id'])){
            ask_permission($_GET['id']);
        }
        else{
            echo json_encode(['message'=>'no']);
        }
    }
    elseif(
        isset($post['getLink'])
    ){
        createLink();
    }


    elseif(
        isset($_GET['search'])
        and isset($_GET['value'])
    ){
        if(!empty($_GET['value']) and ($_GET['search']=='api' or $_GET['search']=='user')){
            if($_GET['search']=='api'){
                api_s(urldecode($_GET['value']));
            }
            else{
                user_s(urldecode($_GET['value']));
            }

        }
        else{
            http_response_code(404);
        }
    }
}


elseif($_SERVER["REQUEST_METHOD"]==="DELETE"){
    $delete = $_GET;
    if(
        isset($delete['delete_api'])
        and isset($delete['id'])
        and isset($delete['type'])
    ){
        if(
            !empty($delete['type'])
            and !empty($delete['id'])
        ){
            delete_api($delete['id'],$delete['type']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(
        isset($delete['delete_line'])
        and isset($delete['table_type'])
        and isset($delete['id'])
    ){
        if(!empty($delete['id']) and !empty($delete['table_type'])){
            delete_line($delete['id'],$delete['table_type']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(isset($delete['logout'])){
        logout();
    }
}


elseif($_SERVER["REQUEST_METHOD"]==='PUT'){
    $put = json_decode(file_get_contents('php://input'),true);
    if(
        isset($put['edit_api'])
        and isset($put['id'])
        and isset($put['type'])
        and isset($put['name'])
    ){
        if(
            !empty($put['type'])
            and !empty($put['id'])
            and !empty($put['name'])
        ){
            edit_api($put['id'],$put['type'],$put['name']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }
    elseif(
        isset($put['continue_api'])
        and isset($put['id'])
        and isset($put['name'])
    ){
        if(
            !empty($put['id'])
            and !empty($put['name'])
        ){
            continue_($put['id'],$put['name']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(
        isset($put['api_status'])
        and isset($put['id'])
    ){
        if(
            !empty($put['id'])
        ){
            api_status($put['id'],$put['api_status']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(
        isset($put['apiNameEdit'])
        and isset($put['name'])
        and isset($put['id'])
    ){
        if(!empty($put['name']) and !empty($put['id'])){
            edit_username($put['id'],$put['name']);
        }
        else{
            echo json_encode(['message'=>'no']);

        }
    }

    elseif(
        isset($put['edit'])
        and isset($put['col'])
        and isset($put['id'])
        and isset($put['value'])
        and isset($put['table'])
    ){
        if(
            !empty($put['col'])
            and !empty($put['id'])
            and !empty($put['value'])
        ){
            edit_cols($put['id'],$put['value'],$put['col']);
        }
        else{
            http_response_code(403);
            readfile($_SERVER['DOCUMENT_ROOT'].'/403.html');
        }
    }

    elseif(
        isset($put['edit'])
        and isset($put['username'])
    ){
        if(!empty($put['username'])){
            editUsername($put['username']);
        }
        else{
            echo json_encode(["message"=>'empty']);
        }
    }
    
    elseif(
        isset($put['edit'])
        and isset($put['password'])
    ){
        if(!empty($put['password'])){
            passwordChecker($put['password']);
        }
        else{
            echo json_encode(["message"=>'empty']);
        }
    }

    elseif(
        isset($put['edit'])
        and isset($put['email'])
    ){
        email($put['email'],2);
    }

}

?>