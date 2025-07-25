<?php

namespace App\Filament\Resources\DocumentoResource\Pages;

use App\Filament\Resources\DocumentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentos extends ManageRecords
{
    protected static string $resource = DocumentoResource::class;

    protected static ?string $title = 'Declarações e Documentos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Documento')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Criar Novo Documento'),
                
        ];
    }
}
