<?php
require dirname(__DIR__) . '/config/app.php';
exigir_post();
$usuario = exigir_login();
verificar_csrf();

$titulo = entrada_texto('titulo');
$materia = entrada_texto('materia');
$prazo = entrada_texto('prazo');
$prioridade = entrada_texto('prioridade');

// checkdate() rejeita datas impossíveis, como 31/02.
$dataValida = false;
if ($prazo !== null && preg_match('/^\d{4}-\d{2}-\d{2}$/', $prazo) === 1) {
    [$ano, $mes, $dia] = array_map('intval', explode('-', $prazo));
    $dataValida = checkdate($mes, $dia, $ano);
}

if ($titulo === null || $titulo === '' || tamanho_texto($titulo) > 90 ||
    $materia === null || $materia === '' || tamanho_texto($materia) > 50 ||
    !$dataValida || !in_array($prioridade, ['baixa', 'media', 'alta'], true)) {
    mensagem('Não foi possível salvar: confira título, matéria, prazo e prioridade.');
    redirecionar('painel.php');
}

// Aqui está a criação explícita de um OBJETO da entidade Tarefa.
$tarefa = new Tarefa(bin2hex(random_bytes(8)), $usuario['id'], $titulo, $materia, $prazo, $prioridade);
$tarefas = ler_registros('tarefas.json');
$tarefas[] = $tarefa->paraArray();
salvar_registros('tarefas.json', $tarefas);

mensagem('Tarefa adicionada com sucesso!');
redirecionar('painel.php');
