<?php

namespace App\Services;

use App\Repositories\Eloquent\FavoritoRepository;
use Illuminate\Validation\ValidationException;

class FavoritoService
{
    public function __construct(
        private FavoritoRepository $repo
    ) {}

    public function addFavorite(int $usuarioId, int $pontoId)
    {
        // Verifica se já existe
        $exists = $this->repo->findByUserAndPonto($usuarioId, $pontoId);

        if ($exists) {
            throw ValidationException::withMessages([
                'favorito' => 'Este ponto já está nos seus favoritos.'
            ]);
        }

        return $this->repo->create([
            'usuario_id' => $usuarioId,
            'ponto_id'   => $pontoId,
        ]);
    }

    /**
     * Lista os favoritos de um usuário específico.
     */
    public function listByUser(int $usuarioId)
    {
        return $this->repo->findByUser($usuarioId);
    }

    /**
     * Remove um favorito.
     */
    public function removeFavorite(int $id)
    {
        return $this->repo->delete($id);
    }
}
