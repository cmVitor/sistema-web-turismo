<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospedagem extends Model
{
    use HasFactory;

    protected $table = 'hospedagens';

    protected $fillable = [
        'ponto_id',
        'nome',
        'endereco',
        'telefone',
        'preco_medio',
        'tipo',
        'link_reserva',
    ];

    protected $casts = [
        'preco_medio' => 'float',
    ];

    public function pontoTuristico()
    {
        return $this->belongsTo(PontoTuristico::class, 'ponto_id');
    }
}
