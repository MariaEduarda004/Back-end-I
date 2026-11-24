<?php
require dirname(__DIR__) . '/config/app.php';
exigir_post();
exigir_login();
verificar_csrf();

$novoTema = tema_atual() === 'claro' ? 'escuro' : 'claro';
$https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
setcookie('tema', $novoTema, [
    'expires' => time() + 30 * 86400, // 30 dias
    'path' => '/',
    'secure' => $https,
    'httponly' => true,
    'samesite' => 'Lax',
]);
redirecionar('painel.php');
