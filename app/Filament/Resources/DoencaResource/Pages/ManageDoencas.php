<?php

namespace App\Filament\Resources\DoencaResource\Pages;

use App\Filament\Resources\DoencaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDoencas extends ManageRecords
{
    protected static string $resource = DoencaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
