<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente',
        'medico_id',
        'data_hora_inicio',
        'data_hora_fim',
        'contato',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_hora_inicio' => 'datetime',
        'data_hora_fim' => 'datetime',
    ];

    public function medico()
    {
        return $this->belongsTo(User::class);
    }
}
