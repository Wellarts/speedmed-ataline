<?php

namespace App\Filament\Resources\AtendimentoClinicoNewResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EncaminhamentosRelationManager extends RelationManager
{
    protected static string $relationship = 'encaminhamentosEspecialidades';

    protected static ?string $title = 'Encaminhamentos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('atendimento_clinico_id')
                    ->default(fn ($record) => $record->id ?? null),
                Forms\Components\Select::make('especialidade_id')
                    ->label('Especialidade')
                    ->relationship('especialidades', 'nome')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->placeholder('Selecione uma especialidade'),
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('atendimento_clinico_id')
            ->columns([
                Tables\Columns\TextColumn::make('especialidades.nome')
                    ->listWithLineBreaks()
                    ->bulleted(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Novo Encaminhamento')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->createAnother(false)
                    ->disabled(fn($livewire) => $livewire->ownerRecord->encaminhamentosEspecialidades()->count() > 0),
                Tables\Actions\Action::make('print')
                    ->label('Imprimir Encaminhamentos')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn($livewire) => route('documentos.encaminhamentos.print', $livewire->ownerRecord->id))
                    ->openUrlInNewTab(),
                    
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
