<?php

namespace App\Policies;

use App\Models\LocalAtendimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocalAtendimentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Locais de Atendimento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LocalAtendimento $localAtendimento): bool
    {
        return $user->hasPermissionTo('Ver Locais de Atendimento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Locais de Atendimento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LocalAtendimento $localAtendimento): bool
    {
        return $user->hasPermissionTo('Atualizar Locais de Atendimento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LocalAtendimento $localAtendimento): bool
    {
        return $user->hasPermissionTo('Deletar Locais de Atendimento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LocalAtendimento $localAtendimento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LocalAtendimento $localAtendimento)
    {
        //
    }
}
