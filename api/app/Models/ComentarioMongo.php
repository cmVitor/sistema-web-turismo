<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as EloquentModel;

class ComentarioMongo extends EloquentModel
{
    protected $connection = 'mongodb';
    protected $collection = 'comentarios'; // nome da coleção

    protected $fillable = [
        'ponto_id',      // id do ponto (relacional)
        'usuario_id',
        'usuario_nome',  // opcional, para facilitar leitura
        'texto',
        'imagens',       // array de URLs
        'created_at',
    ];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at'];
}
