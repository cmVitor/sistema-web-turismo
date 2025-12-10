<?php

namespace App\Http\Controllers;

use App\Services\FavoritoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function __construct(
        private FavoritoService $service
    ) {}

    public function store(Request $request)
    {
        $usuarioId = Auth::id();

        return response()->json(
            $this->service->addFavorite(
                $usuarioId,
                $request->ponto_id
            ),
            201
        );
    }

    public function destroy($id)
    {
        $this->service->removeFavorite($id);
        return response()->json(null, 204);
    }

    public function listByUser($id)
    {
        return response()->json(
            $this->service->listByUser($id)
        );
    }
}
