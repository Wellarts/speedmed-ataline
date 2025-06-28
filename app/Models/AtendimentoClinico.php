<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtendimentoClinico extends Model
{
    use HasFactory;

    protected $table = 'atendimento_clinicos';

    protected $fillable = [
        'paciente_id',
        'data_hora_atendimento',
        'medico_id',
        'tipo_atendimento',
        'qp',
        'hdp',
        'doenca_preexistente',
        'data_inicio_sintomas',
        'cirurgias_hospitalizacoes',
        'medicamento_alergias_id',
        'alimento_alergias',
        'outros_alergias',
        'medicamento_uso_id',
        'medicamento_uso_detalhes',
        'doenca_familiar_id',
        'doenca_familiar_parentesco',
        'tabagismo',
        'alcoolismo',
        'drogas',
        'atividade_fisica',
        'dieta',
        'obs_estilo_vida',
        'dum',
        'pa',
        'peso',
        'altura',
        'imc',
        'fc',
        'fr',
        'temperatura',
        'saturacao',
        'obs_exame_fisico',
        'exame_fisico',
        'hipotese_diagnostica_id',
        'hipotese_diagnostica_detalhes',
        'prescricao_medicamentosa',
        'exames_solicitados',
        'encaminhamentos',
        'orientacoes',
        'evolucao',
        'status',
        'observacoes',
        'anexos_resultados'
    ];

    protected $casts = [
        'data_hora_atendimento' => 'datetime',
        'prescricao_medicamentosa' => 'json',
        'exames_solicitados' => 'json',
        'anexos_resultados' => 'json',
        'doenca_preexistente' => 'array',
        
    ];  
    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class);
    }

    public function doenca()
    {
        return $this->belongsToMany(Doenca::class);
    }

    public function medicamentoAlergias()
    {
        return $this->belongsToMany(Medicamento::class);
    }

    public function medicamentoUso()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_uso_id');
    }

    public function doencaFamiliar()
    {
        return $this->belongsTo(Doenca::class, 'doenca_familiar_id');
    }

    public function hipoteseDiagnostica()
    {
        return $this->belongsTo(Doenca::class, 'hipotese_diagnostica_id');
    }

    public function exames()
    {
        return $this->hasMany(Exame::class, 'exame_id');
    }

    public function encaminhamentos()
    {
        return $this->belongsTo(Especialidade::class, 'encaminhamentos');
    }

}
