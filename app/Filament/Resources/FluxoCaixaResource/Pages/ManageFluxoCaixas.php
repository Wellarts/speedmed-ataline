<?php

namespace App\Filament\Resources\FluxoCaixaResource\Pages;

use App\Filament\Resources\FluxoCaixaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFluxoCaixas extends ManageRecords
{
    protected static string $resource = FluxoCaixaResource::class;

    protected static ?string $title = 'Fluxo de Caixa';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Lançamento')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->after(
                    function ($data, $record) {
                        if ($record->tipo == 'DEBITO') {
                            $record->update([
                                'valor' => $record->valor * -1,
                            ]);
                        }
                    }
                ),
                
        ];
    }
}
