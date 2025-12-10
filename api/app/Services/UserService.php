<?php

namespace App\Services;

use App\Repositories\Eloquent\AddressRepository;
use App\Repositories\Eloquent\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;
    protected $addressRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->all();
    }

    public function update($id, array $data)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new ModelNotFoundException("Usuário não encontrado");
        }

        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new ModelNotFoundException("Usuário não encontrado");
        }

        $this->userRepository->delete($id);
        return ['message' => 'Usuario removido com sucesso.'];
    }

}
