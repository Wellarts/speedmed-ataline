<?php

namespace App\Filament\Resources\FornecedorResource\Pages;

use App\Filament\Resources\FornecedorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFornecedors extends ManageRecords
{
    protected static string $resource = FornecedorResource::class;

    protected static ?string $title = 'Fornecedores';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Fornecedor')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
