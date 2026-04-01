<?php

namespace App\Policies;

use App\Models\Documento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Documentos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Documento $documento): bool
    {
        return $user->hasPermissionTo('Ver Documentos');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Documentos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Documento $documento): bool
    {
        return $user->hasPermissionTo('Atualizar Documentos');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Documento $documento): bool
    {
        return $user->hasPermissionTo('Deletar Documentos');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Documento $documento)
    {
        
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Documento $documento)
    {
        //
    }
}
