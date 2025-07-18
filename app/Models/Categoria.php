<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Categoria extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['nome'];

    public function contasPagar()
    {
        return $this->hasMany(ContasPagar::class);
    }

    public function contasReceber()
    {
        return $this->hasMany(ContasReceber::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
        // Chain fluent methods for configuration options
    }

    
}
