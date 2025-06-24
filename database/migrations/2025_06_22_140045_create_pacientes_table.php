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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique(); // Formato: 000.000.000-00
            $table->string('rg', 20)->nullable();
            $table->tinyInteger('genero')->comment('1=Masculino, 2=Feminino, 3=Outro');
            $table->tinyInteger('estado_civil')->comment('1=Solteiro, 2=Casado, 3=Divorciado, 4=Viúvo');
            $table->string('endereco_completo', 200);
            $table->integer('estado_id')->constrained('estados')->comment('FK para tabela de estados');
            $table->integer('cidade_id')->constrained('cidades')->comment('FK para tabela de cidades');
            $table->string('telefone', 20);
            $table->string('email', 100)->unique();
            $table->string('contato_emergencia', 100);
            $table->tinyInteger('grau_parentesco')->comment('1=Pai/Mãe, 2=Filho(a), 3=Cônjuge, 4=Outro');
            $table->string('profissao', 100)->nullable();
            $table->string('convenio', 100)->nullable();
            $table->timestamps();
            $table->softDeletes(); // Para LGPD (exclusão suave)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
