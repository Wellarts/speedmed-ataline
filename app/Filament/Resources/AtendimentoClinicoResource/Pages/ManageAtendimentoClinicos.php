<?php

namespace App\Filament\Resources\AtendimentoClinicoResource\Pages;

use App\Filament\Resources\AtendimentoClinicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Notifications\Notification;


class ManageAtendimentoClinicos extends ManageRecords
{
    protected static string $resource = AtendimentoClinicoResource::class;

    protected static ?string $title = 'Atendimentos Clínicos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Atendimento Clínico')
                ->icon('heroicon-o-plus')
                ->color('primary'),
                
        ];
    }
}
