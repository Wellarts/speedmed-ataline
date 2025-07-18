<?php

namespace App\Policies;

use App\Models\ContasPagar;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagamentosPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Pagamentos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContasPagar $contasPagar): bool
    {
        return $user->hasPermissionTo('Ver Pagamentos');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Pagamentos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContasPagar $contasPagar): bool
    {
        return $user->hasPermissionTo('Atualizar Pagamentos');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContasPagar $contasPagar): bool
    {
        return $user->hasPermissionTo('Deletar Pagamentos');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContasPagar $contasPagar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContasPagar $contasPagar)
    {
        //
    }
}
