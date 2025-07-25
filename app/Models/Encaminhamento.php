<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encaminhamento extends Model
{
    use HasFactory;

    protected $table = 'encaminhamentos';

    protected $fillable = [
        'atendimento_clinico_id',
        'especialidade_id',
        'descricao',
        
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function atendimentoClinico()
    {
        return $this->belongsTo(AtendimentoClinico::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }

    
}
