<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doenca extends Model
{
    use HasFactory;

    protected $table = 'doencas';

    protected $fillable = [
        'nome',
        'cid',
        'grave'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function atendimentoClinicos()
    {
        return $this->hasMany(AtendimentoClinico::class, 'doenca_id');
    }   

    
}
