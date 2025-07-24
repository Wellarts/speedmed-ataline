<?php

namespace App\Filament\Resources\AtendimentoClinicoNewResource\Pages;

use App\Filament\Resources\AtendimentoClinicoNewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAtendimentoClinicoNew extends CreateRecord
{
    protected static string $resource = AtendimentoClinicoNewResource::class;

    protected static ?string $title = 'Novo Atendimento Clínico';
}
