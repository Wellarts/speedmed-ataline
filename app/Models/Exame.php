<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    use HasFactory;

    protected $table = 'exames';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function atendimentoClinicos()
    {
        return $this->hasMany(AtendimentoClinico::class, 'exame_id');
    }
}
