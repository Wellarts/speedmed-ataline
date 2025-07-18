<?php

namespace App\Policies;

use App\Models\Exame;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Exame');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Exame $exame): bool
    {
        return $user->hasPermissionTo('Ver Exame');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Exame');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Exame $exame): bool
    { 
        return $user->hasPermissionTo('Atualizar Exame');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Exame $exame): bool
    {
       return $user->hasPermissionTo('Deletar Exame');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Exame $exame)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Exame $exame)
    {
        //
    }
}
