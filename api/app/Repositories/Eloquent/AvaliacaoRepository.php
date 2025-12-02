<?php

namespace App\Repositories\Eloquent;

use App\Models\Avaliacao;
use App\Repositories\BaseRepository;

class AvaliacaoRepository extends BaseRepository
{
    public function __construct(Avaliacao $model)
    {
        parent::__construct($model);
    }
    public function findByUserAndPonto(int $userId, int $pontoId)
    {
        return Avaliacao::where('usuario_id', $userId)
            ->where('ponto_id', $pontoId)
            ->first();
    }
}
