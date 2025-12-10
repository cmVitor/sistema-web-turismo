<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComentarioRequest;
use App\Models\ComentarioMongo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComentarioController extends Controller
{
    // GET /api/pontos/{id}/comentarios
    public function index($pontoId)
    {
        $comentarios = ComentarioMongo::where('ponto_id', (int)$pontoId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comentarios);
    }

    // POST /api/pontos/{id}/comentarios
    public function store(StoreComentarioRequest $request, $pontoId)
    {
        $user = $request->user();

        $imagensUrls = [];

        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $file) {
                // salva no disk 'public' 
                $path = $file->store('comentarios', 'public'); // 'public' disk
                $imagensUrls[] = asset("storage/{$path}");;
            }
        }

        $comentario = ComentarioMongo::create([
            'ponto_id'     => (int)$pontoId,
            'usuario_id'   => $user->id,
            'usuario_nome' => $user->name ?? $user->login ?? 'Usuário',
            'texto'        => $request->input('texto'),
            'imagens'      => $imagensUrls,
            'created_at'   => now(),
        ]);

        return response()->json($comentario, 201);
    }
}
