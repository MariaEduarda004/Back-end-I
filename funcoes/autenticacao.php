<?php
// Uma sessão autenticada guarda apenas ID e nome, nunca a senha.

function usuario_logado(): ?array {
    $usuario = $_SESSION['usuario'] ?? null;
    return is_array($usuario) ? $usuario : null;
}

function exigir_login(): array {
    $usuario = usuario_logado();
    if ($usuario === null) {
        redirecionar('login.php');
    }
    return $usuario;
}

function buscar_usuario_por_email(string $email): ?array {
    foreach (ler_registros('usuarios.json') as $usuario) {
        if (is_array($usuario) &&
            isset($usuario['email']) &&
            strcasecmp((string) $usuario['email'], $email) === 0) {
            return $usuario;
        }
    }
    return null;
}
