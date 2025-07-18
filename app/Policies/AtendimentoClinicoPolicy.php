<?php

namespace App\Policies;

use App\Models\AtendimentoClinico;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class AtendimentoClinicoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Atendimento Clinico');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AtendimentoClinico $atendimentoClinico): bool
    {
        return $user->hasPermissionTo('Ver Atendimento Clinico');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Atendimento Clinico');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AtendimentoClinico $atendimentoClinico): bool
    {
        return $user->hasPermissionTo('Atualizar Atendimento Clinico');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AtendimentoClinico $atendimentoClinico): bool
    {
        return $user->hasPermissionTo('Deletar Atendimento Clinico');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AtendimentoClinico $atendimentoClinico)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AtendimentoClinico $atendimentoClinico)
    {
        //
    }
}
