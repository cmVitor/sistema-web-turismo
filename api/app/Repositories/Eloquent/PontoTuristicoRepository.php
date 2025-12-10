<?php

namespace App\Repositories\Eloquent;

use App\Models\PontoTuristico;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class PontoTuristicoRepository extends BaseRepository
{
    public function __construct(PontoTuristico $model)
    {
        parent::__construct($model);
    }
    public function findByNameAndCity(string $nome, string $cidade)
    {
        return PontoTuristico::where('nome', $nome)
            ->where('cidade', $cidade)
            ->first();
    }
    public function calcularMediaNotas(int $pontoId): float
    {
        // Busca todas as notas deste ponto turístico
        $media = DB::table('avaliacoes')
            ->where('ponto_id', $pontoId)
            ->avg('nota');

        return $media ?? 0;
    }
    public function filtrar(array $filters)
    {
        $query = PontoTuristico::query();

        // Filtro por nome
        if (!empty($filters['nome'])) {
            $query->where('nome', 'LIKE', '%' . $filters['nome'] . '%');
        }

        // Filtro por cidade
        if (!empty($filters['cidade'])) {
            $query->where('cidade', 'LIKE', '%' . $filters['cidade'] . '%');
        }

        // Filtro por avaliação (nota média >= X)
        if (!empty($filters['nota'])) {
            $query->where('nota_media', '>=', (int)$filters['nota']);
        }

        return $query->paginate(10);
    }
    public function findManyByIdsOrdered(array $ids)
    {
        $pontos = PontoTuristico::whereIn('id', $ids)->get();

        return $pontos->sortBy(function ($ponto) use ($ids) {
            return array_search($ponto->id, $ids);
        })->values();
    }
}
