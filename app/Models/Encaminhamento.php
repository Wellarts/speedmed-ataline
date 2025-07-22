<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encaminhamento extends Model
{
    use HasFactory;

    protected $table = 'encaminhamentos';

    protected $fillable = [
        'atendimento_id',
        
    ];

    public function atendimentoClinico()
    {
        return $this->belongsTo(AtendimentoClinico::class);
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidade::class, 'atendimento_clinico_encaminhamento', 'atendimento_clinico_id', 'especialidade_id')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function($encaminhamento) {
            $encaminhamento->especialidades()->detach();
        });
    }
}
