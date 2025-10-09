<?php
require_once __DIR__."/base/base.php";
function setCookieForUser($token,$expires){
    setcookie(
        'remember_me',
        $token,
        [
            'expires' => time() + $expires,
            "path" =>"/",
            'secure' => true,
            'httponly'=>true,
            'sameSite'=> 'Lax'
        ]
        
    );
}
function setSession($info, $id){
    $_SESSION['id'] = $id;
    $_SESSION['info'] = $info;
}
function setDbToken($days,$id,$token){
    global $class;
    $dt  = new DateTime();
    $exp = NULL;
    if($days){
        $dt->modify("+ $days days");
        $exp = $dt->format('Y-m-d H:i:s');
    }
    
    $class->query("UPDATE users SET token=:token,exp_date=:exp_date WHERE id=:id",
    ['token'=>$token,'exp_date'=>$exp, 'id'=> $id],2);
}
?>