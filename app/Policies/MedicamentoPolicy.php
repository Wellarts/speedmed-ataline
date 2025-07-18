<?php

namespace App\Policies;

use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicamentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Medicamento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Medicamento $medicamento): bool
    {
        return $user->hasPermissionTo('Ver Medicamento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Medicamento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Medicamento $medicamento): bool
    {
        return $user->hasPermissionTo('Atualizar Medicamento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Medicamento $medicamento): bool
    {
        return $user->hasPermissionTo('Deletar Medicamento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Medicamento $medicamento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Medicamento $medicamento)
    {
        //
    }
}
