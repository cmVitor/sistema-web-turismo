<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoTuristico extends Model
{
    use HasFactory;

    protected $table = 'pontos_turisticos';

    protected $fillable = [
        'nome',
        'descricao',
        'cidade',
        'estado',
        'pais',
        'latitude',
        'longitude',
        'endereco',
        'criado_por',
        'nota_media',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'nota_media' => 'float',
    ];

    public function criador()
    {
        return $this->belongsTo(User::class, 'criado_por');
    }

    public function hospedagens()
    {
        return $this->hasMany(Hospedagem::class, 'ponto_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'ponto_id');
    }

}
