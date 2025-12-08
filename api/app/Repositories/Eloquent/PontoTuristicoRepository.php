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

        // Filtro por cidade
        if (!empty($filters['cidade'])) {
            $query->where('cidade', 'LIKE', '%' . $filters['cidade'] . '%');
        }

        // Filtro por avaliação (nota média >= X)
        if (!empty($filters['avaliacao'])) {
            $query->where('nota_media', '>=', (int)$filters['avaliacao']);
        }

        // // Filtro por tipo de hospedagem
        // if (!empty($filters['tipo'])) {
        //     $query->whereHas('hospedagens', function ($q) use ($filters) {
        //         $q->where('tipo', $filters['tipo']);
        //     });
        // }

        // Filtro por nome
        if (!empty($filters['nome'])) {
            $query->where('nome', 'LIKE', '%' . $filters['nome'] . '%');
        }


        return $query->paginate(10);
    }
}
