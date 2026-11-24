<?php
// Tudo que uma página precisa para utilizar sessão, funções e a entidade Tarefa.
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => $https,
        'cookie_samesite' => 'Lax',
        'use_only_cookies' => true,
    ]);
}

define('PASTA_DADOS', dirname(__DIR__) . '/storage/');

require_once dirname(__DIR__) . '/funcoes/geral.php';
require_once dirname(__DIR__) . '/funcoes/arquivos.php';
require_once dirname(__DIR__) . '/funcoes/autenticacao.php';
require_once dirname(__DIR__) . '/classes/Tarefa.php';
