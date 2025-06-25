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
            Actions\CreateAction::make(),
        ];
    }
}
