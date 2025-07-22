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
                    ->placeholder('Selecione uma especialidade'),
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('atendimento_clinico_id')
            ->columns([
                Tables\Columns\TextColumn::make('atendimento_clinico_id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
