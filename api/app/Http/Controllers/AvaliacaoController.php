<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaliacaoRequest;
use App\Services\AvaliacaoService;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    public function __construct(
        private AvaliacaoService $service
    ) {}

    public function index()
    {
        return response()->json($this->service->paginate());
    }

    public function store(AvaliacaoRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::id();

        return response()->json(
            $this->service->create($data),
            201
        );
    }

    public function update(AvaliacaoRequest $request, $id)
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
