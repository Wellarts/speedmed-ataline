<?php

namespace App\Models;

use Faker\Documentor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Paciente extends Model
{
    use SoftDeletes, LogsActivity; // Para conformidade com LGPD

    protected $table = 'pacientes';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'rg',
        'genero',
        'estado_civil',
        'endereco_completo',
        'estado_id',
        'cidade_id',
        'telefone',
        'email',
        'contato_emergencia',
        'grau_parentesco',
        'profissao',
        'convenio'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function documento()
    {
        return $this->hasMany(Documento::class);
    }



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }

}