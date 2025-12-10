<?php

namespace App\Services;

use App\Repositories\Eloquent\AvaliacaoRepository;
use App\Services\PontoTuristicoService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AvaliacaoService
{
    public function __construct(
        private AvaliacaoRepository $repo,
        private PontoTuristicoService $pontosService
    ) {}

    public function create(array $data)
    {
        // 1. validar nota
        if ($data['nota'] < 1 || $data['nota'] > 5) {
            throw ValidationException::withMessages([
                'nota' => 'A nota deve ser entre 1 e 5.'
            ]);
        }

        // 2. usuário já avaliou?
        $existe = $this->repo->findByUserAndPonto(
            $data['usuario_id'],
            $data['ponto_id']
        );

        if ($existe) {
            throw ValidationException::withMessages([
                'avaliacao' => 'Você já avaliou este ponto turístico.'
            ]);
        }

        // 3. criar avaliação
        $avaliacao = $this->repo->create($data);

        // 4. atualizar média
        $this->pontosService->atualizarMediaNotas($data['ponto_id']);

        Cache::forget("ponto_{$data['ponto_id']}");

        return $avaliacao;
    }

    public function update(int $id, array $data)
    {
        $avaliacao = $this->repo->update($id, $data);

        $this->pontosService->atualizarMediaNotas($avaliacao->ponto_id);

        return $avaliacao;
    }

    public function delete(int $id)
    {
        $avaliacao = $this->repo->find($id);

        $this->repo->delete($id);

        $this->pontosService->atualizarMediaNotas($avaliacao->ponto_id);

        return true;
    }

    public function paginate($perPage = 10)
    {
        return $this->repo->paginate($perPage);
    }
}
