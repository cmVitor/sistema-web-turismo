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
}
