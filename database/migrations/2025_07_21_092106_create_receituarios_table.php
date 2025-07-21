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
        Schema::create('receituarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atendimento_clinico_id');
            $table->foreignId('medicamento_id');
            $table->string('qtd');
            $table->string('forma_uso'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receituarios');
    }
};
