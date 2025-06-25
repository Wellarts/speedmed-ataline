<?php

namespace App\Filament\Resources\AtendimentoClinicoResource\Pages;

use App\Filament\Resources\AtendimentoClinicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAtendimentoClinicos extends ManageRecords
{
    protected static string $resource = AtendimentoClinicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
