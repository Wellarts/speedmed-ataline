<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antedimento_clinicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id');
            $table->timestamp('data_hora_atendimento');
            $table->foreignId('medico_id');
            $table->integer('tipo_atendimento');
            $table->string('qp', 255);
            $table->longText('hdp');
            $table->foreignId('doenca_id');
            $table->year('data_inicio_sintomas');
            $table->longText('cirurgias_hospitalizacoes');
            $table->foreignId('medicamento_alergias_id');
            $table->string('alimento_alergias', 100);
            $table->string('outros_alergias', 100);
            $table->foreignId('medicamento_uso_id');
            $table->string('medicamento_uso_detalhes', 255);
            $table->foreignId('doenca_familiar_id');
            $table->integer('doenca_familiar_parentesco');
            $table->boolean('tabagismo');
            $table->boolean('alcoolismo');
            $table->boolean('drogas');
            $table->boolean('atividade_fisica');
            $table->string('dieta', 1);
            $table->string('obs_estilo_vida', 255);
            $table->date('dum');
            $table->string('pa',10);
            $table->string('peso', 10);
            $table->string('altura', 10);
            $table->string('imc', 10);
            $table->string('fc', 10);
            $table->string('fr', 10);
            $table->string('temperatura', 10);
            $table->string('saturacao', 10);
            $table->string('glicemia', 10);
            $table->string('obs_exame_fisico', 255);
            $table->string('exame_fisico', 255);
            $table->foreignId('hipotese_diagnostica_id');
            $table->string('hipotese_diagnostica_detalhes', 255);
            $table->json('prescricao_medicamentosa');
            $table->json('exames_solicitados');                   
            $table->foreignId('encaminhamentos');         
            $table->longText('orientacoes');
            $table->longText('evolucao');
            $table->string('status',2);
            $table->longText('observacoes');
            $table->string('anexos_resultados', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antedimento_clinicos');
    }
};
