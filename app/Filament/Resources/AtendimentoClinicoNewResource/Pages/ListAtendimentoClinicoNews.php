<?php

namespace App\Filament\Resources\AtendimentoClinicoNewResource\Pages;

use App\Filament\Resources\AtendimentoClinicoNewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtendimentoClinicoNews extends ListRecords
{
    protected static string $resource = AtendimentoClinicoNewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
