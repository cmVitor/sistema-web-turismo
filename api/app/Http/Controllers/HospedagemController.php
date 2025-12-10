<?php

namespace App\Http\Controllers;

use App\Http\Requests\HospedagemRequest;
use App\Services\HospedagemService;

class HospedagemController extends Controller
{
    public function __construct(
        private HospedagemService $service
    ) {}

    public function index()
    {
        return response()->json($this->service->paginate());
    }
    
    public function store(HospedagemRequest $request)
    {
        return response()->json(
            $this->service->create($request->validated()),
            201
        );
    }

    public function update(HospedagemRequest $request, $id)
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

    public function listarPorPonto(int $id)
    {
        return response()->json(
            $this->service->listarPorPonto($id)
        );
    }
}
