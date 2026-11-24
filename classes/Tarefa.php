<?php
class Tarefa
{
    public string $id;
    public string $usuarioId;
    public string $titulo;
    public string $materia;
    public string $prazo;
    public string $prioridade;
    public bool $concluida;

    public function __construct(
        string $id,
        string $usuarioId,
        string $titulo,
        string $materia,
        string $prazo,
        string $prioridade
    ) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->titulo = $titulo;
        $this->materia = $materia;
        $this->prazo = $prazo;
        $this->prioridade = $prioridade;
        $this->concluida = false;
    }

    // JSON armazena texto/arrays: transformamos o objeto em array antes de salvar.
    public function paraArray(): array
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuarioId,
            'titulo' => $this->titulo,
            'materia' => $this->materia,
            'prazo' => $this->prazo,
            'prioridade' => $this->prioridade,
            'concluida' => $this->concluida,
        ];
    }
}
