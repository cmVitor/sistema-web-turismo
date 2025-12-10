<?php

namespace App\Repositories\Eloquent;

use App\Models\Favorito;
use App\Repositories\BaseRepository;

class FavoritoRepository extends BaseRepository
{
    public function __construct(Favorito $model)
    {
        parent::__construct($model);
    }
    public function findByUserAndPonto(int $usuarioId, int $pontoId)
    {
        return Favorito::where('usuario_id', $usuarioId)
            ->where('ponto_id', $pontoId)
            ->first();
    }

    public function findByUser(int $usuarioId)
    {
        return Favorito::where('usuario_id', $usuarioId)
            ->with('ponto') 
            ->get();
    }
}