<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes; // Para conformidade com LGPD

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
}