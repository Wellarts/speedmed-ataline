<?php

namespace App\Policies;

use App\Models\GrupoExame;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GrupoExamesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return $user->hasPermissionTo('Ver Grupo de Exames');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GrupoExame $grupoExame): bool
    {
        return $user->hasPermissionTo('Ver Grupo de Exames');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Grupo de Exames');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GrupoExame $grupoExame): bool
    {
        return $user->hasPermissionTo('Atualizar Grupo de Exames');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GrupoExame $grupoExame): bool
    {
        return $user->hasPermissionTo('Deletar Grupo de Exames');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GrupoExame $grupoExame)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GrupoExame $grupoExame)
    {
        //
    }
}
