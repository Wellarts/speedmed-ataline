<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\AtendimentoClinico;
use App\Models\Categoria;
use App\Models\ContasPagar;
use App\Models\ContasReceber;
use App\Models\Documento;
use App\Models\Doenca;
use App\Models\Especialidade;
use App\Models\Exame;
use App\Models\FluxoCaixa;
use App\Models\Fornecedor;
use App\Models\GrupoExame;
use App\Models\LocalAtendimento;
use App\Models\Medicamento;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Receituario;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\AtendimentoClinicoPolicy;
use App\Policies\CategoriaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Policies\GrupoExamesPolicy;
use App\Policies\PagamentosPolicy;
use App\Policies\RecebimentosPolicy;
use App\Policies\LocalAtendimentoPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Policies\DocumentoPolicy;
use App\Policies\DoencaPolicy;
use App\Policies\ExamePolicy;
use App\Policies\EspecialidadePolicy;
use App\Policies\FluxoCaixaPolicy;
use App\Policies\FornecedorPolicy;
use App\Policies\MedicamentoPolicy;
use App\Policies\MedicoPolicy;
use App\Policies\PacientePolicy;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        ContasPagar::class => PagamentosPolicy::class,
        ContasReceber::class => RecebimentosPolicy::class,
        GrupoExame::class => GrupoExamesPolicy::class,
        LocalAtendimento::class => LocalAtendimentoPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
        AtendimentoClinico::class => AtendimentoClinicoPolicy::class,
        Categoria::class => CategoriaPolicy::class,
        Documento::class => DocumentoPolicy::class,
        Doenca::class => DoencaPolicy::class,
        Exame::class => ExamePolicy::class,
        Especialidade::class => EspecialidadePolicy::class,
        FluxoCaixa::class => FluxoCaixaPolicy::class,
        Fornecedor::class => FornecedorPolicy::class,
        Paciente::class => PacientePolicy::class,        
        Medicamento::class => MedicamentoPolicy::class,
        Medico::class => MedicoPolicy::class,
        Activity::class => ActivityPolicy::class,
            
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
