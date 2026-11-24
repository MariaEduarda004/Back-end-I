<?php
require dirname(__DIR__) . '/config/app.php';
exigir_post();
verificar_csrf();

$_SESSION = [];
$parametros = session_get_cookie_params();
$opcoes = [
    'expires' => time() - 3600,
    'path' => $parametros['path'],
    'secure' => $parametros['secure'],
    'httponly' => $parametros['httponly'],
    'samesite' => $parametros['samesite'],
];
if ($parametros['domain'] !== '') {
    $opcoes['domain'] = $parametros['domain'];
}
setcookie(session_name(), '', $opcoes);
session_destroy();
redirecionar('login.php');
