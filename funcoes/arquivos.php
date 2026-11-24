<?php
// Persistência didática em JSON: ler -> alterar o array -> salvar.

function ler_registros(string $nome): array {
    $caminho = PASTA_DADOS . $nome;
    if (!is_file($caminho)) {
        return [];
    }

    $texto = file_get_contents($caminho);
    if ($texto === false) {
        throw new RuntimeException('Não foi possível ler os dados.');
    }

    $registros = json_decode($texto, true);
    if (!is_array($registros)) {
        throw new RuntimeException('O arquivo JSON está inválido.');
    }
    return $registros;
}

function salvar_registros(string $nome, array $registros): void {
    $caminho = PASTA_DADOS . $nome;
    $texto = json_encode(
        $registros,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
    );
    $bytes = file_put_contents($caminho, $texto, LOCK_EX);

    if ($bytes === false || $bytes !== strlen($texto)) {
        throw new RuntimeException('Não foi possível salvar os dados.');
    }
}
