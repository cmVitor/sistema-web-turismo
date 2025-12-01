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
}
