<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Medicamento extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'medicamentos';
    protected $fillable = [
        'nome',
        'principio_ativo',
        'alergia',
        'uso_continuo',
        'controle_especial'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function atendimentosClinicos()
    {
        return $this->hasMany(AtendimentoClinico::class, 'medicamento_uso_id');
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }
}
