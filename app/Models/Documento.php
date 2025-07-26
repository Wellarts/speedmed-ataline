<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'paciente_id',
        'data_hora',
        'descricao',
    ];  

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    } 

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }


    
    
    
    


}
