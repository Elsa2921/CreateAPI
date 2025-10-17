<?php
session_start();
// session_set_cookie_params([
//     'secure' => true,      
//     'httponly' => true,
//     'samesite' => 'None'    
// ]);

date_default_timezone_set("UTC");

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
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (!empty($origin) and $origin==$_ENV['ALLOWED_ORIGINS']) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
}

$uri = $_SERVER['REQUEST_URI'];
$script = $_SERVER['SCRIPT_NAME'];
$path = str_replace($script,'',$uri);
$path = parse_url($path,PHP_URL_PATH);
$segments = explode('/',trim($path, '/'));

$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;


if($_SERVER['REQUEST_METHOD']==='POST'){
    $post = json_decode(file_get_contents('php://input'),true);
    if(
        isset($post['username'])
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
        isset($post['code'])
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
        and isset($post['rememberMe'])
    ){
        if(
            !empty($post['email'])
            and !empty($post['password'])
        ){
            
            login($post['email'],$post['password'],$post['rememberMe']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(isset($post['id_token']) and isset($post['google_auth'])){
        gg_auth($post['id_token']);
    }

    elseif(
        isset($post['newApi'])
        and $resource === 'api'
        and !is_null($id)
    ){
        api_name($id);
        
    }

    elseif(
        isset($post['apiType'])
        and !is_null($id)
        and $resource==='api'
    ){
        select($id);
       
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
        $resource === 'notification'
        and !is_null($id)
        and isset($post['notif'])
        and isset($post['api_id'])
        and isset($post['from'])
    ){
        if(
            !empty($id)
            and !empty($post['api_id'])
            and !empty($post['from'])
            ){
                if($post['notif']){
                    allow_notif($id,$post['api_id'],$post['from']);
                }else{
                    deny_notif($id,$post['api_id'],$post['from']);

                }
            
        }
        else{
            echo json_encode(['message'=>'no']);

        }
    }

    elseif(
        $resource === 'notification'
        and isset($post['readAll'])
    ){
        if(is_null($id) and $post['readAll']){
            read_notif();
        }
        else{
            read_notif($id);

        }
    }

    elseif(
        isset($post['ask_permission'])
        and $resource === 'api'
    ){
        if(!is_null($id)){
            ask_permission($id);
        }
        else{
            echo json_encode(['message'=>'no']);
        }
    }
}


elseif($_SERVER["REQUEST_METHOD"]==='GET'){
    if($resource==='users'  and empty($_GET)){
        if(is_null($id)){
            reloadChecker();
            
        }
        else{
            visit_p($id);

        }
    
    }
        
    

    elseif(
        $resource === 'profile'
    ){
        if(is_null($id)){
            g_p();
        }
    }

    elseif(
        $resource==='table'
        and is_null($id)

    ){
        tablePageReload();
    }

    elseif(
        isset($_GET['Oprofile'])
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
        $resource === 'link'
        and is_null($id)
    ){
        createLink();
    }


    elseif(
        isset($_GET['search'])
        and !empty($_GET['search'])
    ){
        if($resource==='users'){
            user_s(urldecode($_GET['search']));

        }
        else{
            api_s(urldecode($_GET['search']));

        }
    }
    elseif(
        $resource === 'view'
        and !is_null($id)
    ){
        view_($id);
    }
}


elseif($_SERVER["REQUEST_METHOD"]==="DELETE"){
    $delete = $_GET;
    if(
        isset($delete['delete_api'])
        and !is_null($id)
        and $resource==='api'
    ){
        if(
            !empty($delete['delete_api'])
            and !empty($id)
        ){
            delete_api($id,$delete['delete_api']);
        }else{
            echo json_encode(['message'=>'no']);
            exit();
        }
    }

    elseif(
        $resource === 'table'
        and isset($delete['table_type'])
        and !is_null($id)
    ){
        delete_line($id,$delete['table_type']);

    }

    elseif($resource==='logout'){
        logout();
    }
}


elseif($_SERVER["REQUEST_METHOD"]==='PUT'){
    $put = json_decode(file_get_contents('php://input'),true);
    if(
        $resource === 'api'
        and !is_null($id)
        and isset($put['type'])
        and isset($put['name'])
    ){
        edit_api($id,$put['type'],$put['name']);
    }
    elseif(
        isset($put['continue_api'])
        and !is_null($id)
        and $resource === 'api'
        and isset($put['name'])
    ){
        continue_($id,$put['name']);
    }

    elseif(
        isset($put['api_status'])
        and !is_null($id)
        and $resource === 'api'
    ){
        api_status($id,$put['api_status']);
    }

    elseif(
        isset($put['apiNameEdit'])
        and $resource === 'api'
        and !is_null($id)
    ){
        if(!empty($put['apiNameEdit'])){
            edit_username($id,$put['apiNameEdit']);
        }
        else{
            echo json_encode(['message'=>'no']);

        }
    }

    elseif(
        isset($put['col'])
        and isset($put['value'])
        and isset($put['tableRowEdit'])
        and $resource==='table'
    ){
        if(
            !empty($put['col'])
            and !is_null($id)
            and !empty($put['value'])
        ){
            edit_cols($id,$put['value'],$put['col']);
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