<?php
require dirname(__DIR__) . '/config/app.php';
if (usuario_logado() !== null) {
    redirecionar('painel.php');
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_csrf();
    $email = entrada_texto('email');
    $senha = $_POST['senha'] ?? null;

    if ($email === null || !is_string($senha) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        http_response_code(400);
        $erro = 'Informe um e-mail e uma senha válidos.';
    } else {
        $usuario = buscar_usuario_por_email($email);
        if ($usuario !== null && password_verify($senha, (string) $usuario['senha_hash'])) {
            // Troca o identificador da sessão após o login, mantendo seus dados.
            session_regenerate_id(true);
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
            ];
            redirecionar('painel.php');
        }
        http_response_code(401);
        $erro = 'E-mail ou senha incorretos.';
    }
}

$tituloPagina = 'Entrar';
require dirname(__DIR__) . '/views/header.php';
?>
<div class="auth-layout">
    <section class="intro">
        <span class="eyebrow">Login</span>
        <h1>Agenda de Estudos</h1>
        <p>Entre no sistema e organize suas atividades por matéria, prazo e prioridade.</p>
    </section>
    <section class="panel auth-panel">
        <h2>Entrar</h2>
        <p class="muted">Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a>.</p>
        <?php if ($erro !== ''): ?>
            <p class="alert erro"><?= escapar($erro) ?></p><?php endif; ?>
        <form method="post" action="login.php">
            <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
            <label>E-mail<input type="email" name="email" autocomplete="username" required></label>
            <label>Senha<input type="password" name="senha" autocomplete="current-password" required></label>
            <button class="btn full" type="submit">Acessar painel</button>
        </form>
    </section>
</div>
<?php require dirname(__DIR__) . '/views/footer.php'; ?>