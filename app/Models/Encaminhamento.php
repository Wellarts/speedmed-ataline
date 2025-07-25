<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encaminhamento extends Model
{
    use HasFactory;

    protected $table = 'encaminhamentos';

    protected $fillable = [
        'encaminhamento_id',
        'descricao',
        
    ];

    public function atendimentoClinico()
    {
        return $this->belongsTo(AtendimentoClinico::class);
    }

    public function especialidades()
    {
        return $this->belongsTo(Especialidade::class);
    }

    
}
