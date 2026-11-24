<?php
require dirname(__DIR__) . '/config/app.php';

if (usuario_logado() !== null) {
    redirecionar('painel.php');
}
redirecionar('login.php');
