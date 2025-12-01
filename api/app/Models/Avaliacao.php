<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'ponto_id',
        'usuario_id',
        'nota',
        'comentario',
    ];

    protected $casts = [
        'nota' => 'integer',
    ];

    public function pontoTuristico()
    {
        return $this->belongsTo(PontoTuristico::class, 'ponto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
