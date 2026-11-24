<?php
require dirname(__DIR__) . '/config/app.php';
if (usuario_logado() !== null) {
    redirecionar('painel.php');
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_csrf();
    $nome = entrada_texto('nome');
    $email = entrada_texto('email');
    $senha = $_POST['senha'] ?? null;

    $nomeValido = $nome !== null && tamanho_texto($nome) >= 2 && tamanho_texto($nome) <= 60;
    $emailValido = $email !== null && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    $senhaValida = is_string($senha) && strlen($senha) >= 8;

    if (!$nomeValido || !$emailValido || !$senhaValida) {
        http_response_code(400);
        $erro = 'Informe nome (2 a 60 caracteres), e-mail válido e senha de pelo menos 8 caracteres.';
    } elseif (buscar_usuario_por_email($email) !== null) {
        http_response_code(409);
        $erro = 'Este e-mail já está cadastrado.';
    } else {
        $usuarios = ler_registros('usuarios.json');
        $usuarios[] = [
            'id' => bin2hex(random_bytes(8)),
            'nome' => $nome,
            'email' => strtolower($email),
            'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
        ];
        salvar_registros('usuarios.json', $usuarios);
        mensagem('Conta criada! Agora faça seu login.');
        redirecionar('login.php');
    }
}

$tituloPagina = 'Criar conta';
require dirname(__DIR__) . '/views/header.php';
?>
<div class="auth-layout">
    <section class="intro">
        <span class="eyebrow">CADASTRO</span>
        <h1>Agenda de Estudos</h1>
        <p>Entre no sistema e organize suas atividades por matéria, prazo e prioridade.</p>
    </section>
    <section class="panel auth-panel">
        <h2>Criar conta</h2>
        <p class="muted">Já tem conta? <a href="login.php">Entrar</a>.</p>
        <?php if ($erro !== ''): ?>
            <p class="alert erro"><?= escapar($erro) ?></p><?php endif; ?>
        <form method="post" action="cadastro.php">
            <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
            <label>Nome completo<input name="nome" maxlength="60" autocomplete="name" required></label>
            <label>E-mail<input type="email" name="email" autocomplete="email" required></label>
            <label>Senha<input type="password" name="senha" minlength="8" autocomplete="new-password" required></label>
            <button class="btn full" type="submit">Cadastrar</button>
        </form>
    </section>
</div>
<?php require dirname(__DIR__) . '/views/footer.php'; ?>