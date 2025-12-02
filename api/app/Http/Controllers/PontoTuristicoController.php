<?php

namespace App\Http\Controllers;

use App\Http\Requests\PontoTuristicoRequest;
use App\Services\PontoTuristicoService;

class PontoTuristicoController extends Controller
{
    public function __construct(
        private PontoTuristicoService $service
    ) {}

    public function index()
    {
        return response()->json($this->service->paginate());
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    public function store(PontoTuristicoRequest $request)
    {
        return response()->json(
            $this->service->create($request->validated()),
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
