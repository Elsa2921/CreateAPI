<?php
require_once __DIR__. "/../setCookie.php";
function logout(){
    setCookieForUser('',-3600);
    setDbToken(false,$_SESSION['id'],NULL);
    session_destroy();
    echo json_encode(['ok']);
}

?>