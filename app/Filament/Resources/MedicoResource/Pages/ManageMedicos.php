<?php

namespace App\Filament\Resources\MedicoResource\Pages;

use App\Filament\Resources\MedicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMedicos extends ManageRecords
{
    protected static string $resource = MedicoResource::class;

    protected static ?string $title = 'Médicos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Médico')
                ->icon('heroicon-o-user-plus')
                ->modalHeading('Cadastrar Novo Médico')
        ];
    }
}
