<?php

namespace App\Filament\Resources\ExameResource\Pages;

use App\Filament\Resources\ExameResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageExames extends ManageRecords
{
    protected static string $resource = ExameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Exame')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Criar Novo Exame'),
        ];
    }
}
