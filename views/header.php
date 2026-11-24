<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escapar($tituloPagina ?? 'Agenda de Estudos') ?> · Agenda de Estudos</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class="<?= escapar(tema_atual()) ?>">
    <header class="topbar">
        <div class="top-inner">
            <nav aria-label="Navegação principal">
                <?php if (usuario_logado() !== null): ?>
                    <a href="painel.php">Painel</a>
                    <form method="post" action="tema.php" class="inline-form">
                        <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
                        <button type="submit" class="nav-link">Trocar tema</button>
                    </form>
                    <form method="post" action="logout.php" class="inline-form">
                        <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
                        <button type="submit" class="nav-logout">Sair</button>
                    </form>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a href="cadastro.php" class="nav-logout">Criar conta</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php $mensagem = obter_mensagem(); ?>
        <?php if ($mensagem !== null): ?>
            <div class="alert notice" role="status"><?= escapar($mensagem) ?></div><?php endif; ?>