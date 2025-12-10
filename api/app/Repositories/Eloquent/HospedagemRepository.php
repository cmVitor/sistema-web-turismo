<?php

namespace App\Repositories\Eloquent;

use App\Models\Hospedagem;
use App\Repositories\BaseRepository;

class HospedagemRepository extends BaseRepository
{
    public function __construct(Hospedagem $model)
    {
        parent::__construct($model);
    }

    public function findByPonto(int $pontoId)
    {
        return Hospedagem::where('ponto_id', $pontoId)->get();
    }
}
