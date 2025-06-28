<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';  
    protected $fillable = [
        'nome',
        'principio_ativo',
        'alergia'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function atendimentosClinicos()
    {
        return $this->hasMany(AtendimentoClinico::class, 'medicamento_uso_id');
    }
    
    }

