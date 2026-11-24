<?php
// Funções pequenas reutilizadas pelas páginas.

function escapar(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirecionar(string $pagina): never {
    header('Location: ' . $pagina, true, 303);
    exit;
}

function exigir_post(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        header('Allow: POST');
        http_response_code(405);
        exit('Método não permitido. Envie o formulário por POST.');
    }
}

function token_csrf(): string {
    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verificar_csrf(): void {
    $recebido = $_POST['csrf'] ?? null;
    if (!is_string($recebido) || !hash_equals(token_csrf(), $recebido)) {
        http_response_code(403);
        exit('Formulário inválido. Atualize a página e tente novamente.');
    }
}

function entrada_texto(string $campo): ?string {
    $valor = $_POST[$campo] ?? null;
    // Evita converter um array enviado indevidamente em texto "Array".
    return is_string($valor) ? trim($valor) : null;
}

function tamanho_texto(string $texto): int {
    // Conta caracteres UTF-8 sem exigir a extensão mbstring.
    $total = preg_match_all('/./us', $texto);
    return $total === false ? PHP_INT_MAX : $total;
}

function mensagem(string $texto): void {
    $_SESSION['mensagem'] = $texto;
}

function obter_mensagem(): ?string {
    $texto = $_SESSION['mensagem'] ?? null;
    unset($_SESSION['mensagem']);
    return is_string($texto) ? $texto : null;
}

function tema_atual(): string {
    return ($_COOKIE['tema'] ?? '') === 'escuro' ? 'escuro' : 'claro';
}
