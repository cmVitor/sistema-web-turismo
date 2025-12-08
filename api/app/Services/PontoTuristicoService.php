<?php

namespace App\Services;

use App\Repositories\Eloquent\PontoTuristicoRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class PontoTuristicoService
{
    public function __construct(
        private PontoTuristicoRepository $repo
    ) {}

    public function all()
    {
        return $this->repo->all();
    }

    public function paginate($perPage = 10)
    {
        return $this->repo->paginate($perPage);
    }

    public function find(int $id)
    {
        // Cache para acessos frequentes
        return Cache::remember("ponto_{$id}", 60, function () use ($id) {
            return $this->repo->find($id);
        });
    }

    public function create(array $data)
    {
        // regra: não pode haver dois pontos na mesma cidade com mesmo nome
        $existing = $this->repo->findByNameAndCity($data['nome'], $data['cidade']);

        if ($existing) {
            throw ValidationException::withMessages([
                'nome' => 'Já existe um ponto turístico com este nome nesta cidade.'
            ]);
        }

        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id)
    {
        Cache::forget("ponto_{$id}");
        return $this->repo->delete($id);
    }

    public function atualizarMediaNotas(int $pontoId)
    {
        $media = $this->repo->calcularMediaNotas($pontoId);

        return $this->repo->update($pontoId, ['nota_media' => $media]);
    }

    public function filtrar(array $filters)
    {
        return $this->repo->filtrar($filters);
    }
}
