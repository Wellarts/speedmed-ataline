<?php

namespace App\Policies;

use App\Models\FluxoCaixa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FluxoCaixaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Fluxo de Caixa');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FluxoCaixa $fluxoCaixa): bool
    {
        return $user->hasPermissionTo('Ver Fluxo de Caixa');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Fluxo de Caixa');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FluxoCaixa $fluxoCaixa): bool
    {
        return $user->hasPermissionTo('Atualizar Fluxo de Caixa');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FluxoCaixa $fluxoCaixa): bool
    {
        return $user->hasPermissionTo('Deletar Fluxo de Caixa');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FluxoCaixa $fluxoCaixa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FluxoCaixa $fluxoCaixa)
    {
        //
    }
}
