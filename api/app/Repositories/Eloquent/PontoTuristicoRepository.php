<?php

namespace App\Repositories\Eloquent;

use App\Models\PontoTuristico;
use App\Repositories\BaseRepository;

class PontoTuristicoRepository extends BaseRepository
{
    public function __construct(PontoTuristico $model)
    {
        parent::__construct($model);
    }
}
