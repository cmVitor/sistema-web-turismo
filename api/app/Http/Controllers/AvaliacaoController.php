<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaliacaoRequest;
use App\Services\AvaliacaoService;

class AvaliacaoController extends Controller
{
    public function __construct(
        private AvaliacaoService $service
    ) {}

    public function store(AvaliacaoRequest $request)
    {
        return response()->json(
            $this->service->create($request->validated()),
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
