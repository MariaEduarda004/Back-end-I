<?php
require dirname(__DIR__) . '/config/app.php';
exigir_post();
$usuario = exigir_login();
verificar_csrf();

$id = entrada_texto('id');
$tarefas = ler_registros('tarefas.json');
$encontrada = false;

foreach ($tarefas as &$tarefa) {
    // Segurança: o ID da tarefa e o ID de seu dono precisam corresponder.
    if ($id !== null &&
        ($tarefa['id'] ?? null) === $id &&
        ($tarefa['usuario_id'] ?? null) === $usuario['id']) {
        $tarefa['concluida'] = true;
        $encontrada = true;
        break;
    }
}
unset($tarefa);

if ($encontrada) {
    salvar_registros('tarefas.json', $tarefas);
    mensagem('Tarefa marcada como concluída.');
} else {
    mensagem('Tarefa não encontrada ou sem permissão para alterar.');
}
redirecionar('painel.php');
