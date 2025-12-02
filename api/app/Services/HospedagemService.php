<?php

namespace App\Services;

use App\Repositories\Eloquent\HospedagemRepository;

class HospedagemService
{
    public function __construct(
        private HospedagemRepository $repo
    ) {}

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}
