<?php

namespace App\Http\Controllers;

use App\Http\Requests\PontoTuristicoRequest;
use App\Services\PontoTuristicoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PontoTuristicoController extends Controller
{
    public function __construct(
        private PontoTuristicoService $service
    ) {}

    public function index(Request $request)
    {
        // se não houver filtros → paginate normal
        if (!$request->hasAny(['cidade', 'avaliacao', 'tipo'])) {
            return response()->json($this->service->paginate());
        }

        return response()->json(
            $this->service->filtrar($request->only(['cidade', 'avaliacao', 'tipo']))
        );
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    public function store(PontoTuristicoRequest $request)
    {
        $data = $request->validated();
        $data['criado_por'] = Auth::id();

        return response()->json(
            $this->service->create($data),
            201
        );
    }

    public function update(PontoTuristicoRequest $request, $id)
    {
        return response()->json(
            $this->service->update($id, $request->validated())
        );
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
