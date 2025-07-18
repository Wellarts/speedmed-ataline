<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Doenca extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }

    
}
