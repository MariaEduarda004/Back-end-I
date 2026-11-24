<?php
require dirname(__DIR__) . '/config/app.php';
$usuario = exigir_login();

// Filtra os registros: cada pessoa vê apenas suas próprias tarefas.
$tarefas = [];
foreach (ler_registros('tarefas.json') as $tarefa) {
    if (is_array($tarefa) && ($tarefa['usuario_id'] ?? null) === $usuario['id']) {
        $tarefas[] = $tarefa;
    }
}
$total = count($tarefas);
$concluidas = count(array_filter($tarefas, fn($t) => !empty($t['concluida'])));
$pendentes = $total - $concluidas;

$tituloPagina = 'Meu painel';
require dirname(__DIR__) . '/views/header.php';
?>
<div class="heading">
    <div>
        <span class="eyebrow">ÁREA PROTEGIDA POR SESSÃO</span>
        <h1>Olá, <?= escapar((string) $usuario['nome']) ?>!</h1>
        <p>Organize os próximos passos dos seus estudos.</p>
    </div>
    <span class="user-chip">Sessão ativa</span>
</div>

<section class="stats" aria-label="Resumo das tarefas">
    <div class="stat"><span>Total de tarefas</span><strong><?= $total ?></strong></div>
    <div class="stat"><span>Pendentes</span><strong><?= $pendentes ?></strong></div>
    <div class="stat"><span>Concluídas</span><strong><?= $concluidas ?></strong></div>
</section>

<div class="columns">
    <section class="panel">
        <span class="eyebrow">CADASTRAR</span>
        <h2>Nova tarefa</h2>
        <p class="muted">Quatro campos principais para a entidade Tarefa.</p>
        <form method="post" action="salvar_tarefa.php">
            <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
            <label>Título<input name="titulo" maxlength="90" placeholder="Ex.: Estudar PHP" required></label>
            <label>Matéria<input name="materia" maxlength="50" placeholder="Ex.: Back-end I" required></label>
            <label>Prazo<input type="date" name="prazo" required></label>
            <label>Prioridade
                <select name="prioridade" required>
                    <option value="media">Média</option>
                    <option value="alta">Alta</option>
                    <option value="baixa">Baixa</option>
                </select>
            </label>
            <button class="btn full" type="submit">Adicionar tarefa</button>
        </form>
    </section>

    <section class="panel task-panel">
        <div class="list-head"><div><span class="eyebrow">CONSULTAR</span><h2>Minhas tarefas</h2></div><span class="count"><?= $total ?> registro(s)</span></div>
        <?php if ($tarefas === []): ?>
            <div class="empty"><strong>Você ainda não tem tarefas.</strong><p>Cadastre a primeira atividade no formulário ao lado.</p></div>
        <?php else: ?>
            <div class="task-list">
                <?php foreach (array_reverse($tarefas) as $tarefa): ?>
                    <article class="task <?= !empty($tarefa['concluida']) ? 'done' : '' ?>">
                        <div class="task-text">
                            <strong><?= escapar((string) $tarefa['titulo']) ?></strong>
                            <div class="meta">
                                <?= escapar((string) $tarefa['materia']) ?> ·
                                Prazo: <?= escapar((string) $tarefa['prazo']) ?>
                                <span class="priority <?= escapar((string) $tarefa['prioridade']) ?>"><?= escapar((string) $tarefa['prioridade']) ?></span>
                            </div>
                        </div>
                        <?php if (!empty($tarefa['concluida'])): ?>
                            <span class="finished">Concluída</span>
                        <?php else: ?>
                            <form method="post" action="concluir_tarefa.php">
                                <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
                                <input type="hidden" name="id" value="<?= escapar((string) $tarefa['id']) ?>">
                                <button class="btn small" type="submit">Concluir</button>
                            </form>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>
<?php require dirname(__DIR__) . '/views/footer.php'; ?>
