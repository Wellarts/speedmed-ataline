<?php

namespace App\Filament\Resources\PacienteResource\Pages;

use App\Filament\Resources\PacienteResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePacientes extends ManageRecords
{
    protected static string $resource = PacienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Paciente')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->tooltip('Criar novo paciente'),
        ];
    }
}
