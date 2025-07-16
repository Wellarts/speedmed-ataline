<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'nome',
        'crm',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function atendimentos()
    {
        return $this->hasMany(AtendimentoClinico::class);
    }
}
