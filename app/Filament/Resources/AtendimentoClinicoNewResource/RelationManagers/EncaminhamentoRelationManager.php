<?php

namespace App\Filament\Resources\AtendimentoClinicoNewResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EncaminhamentoRelationManager extends RelationManager
{
    protected static string $relationship = 'Encaminhamento';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('atendimento_clinico_id')
                    ->default((function ($livewire): int {
                                return $livewire->ownerRecord->id;
                            })),
                Forms\Components\Select::make('especialidade_id')
                    ->relationship('especialidade', 'nome')
                    ->required()
                    ->searchable()
                    ->label('Especialidade'),
                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição')  
                    ->autosize(),                  
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('atendimento_clinico_id')
            ->columns([
                Tables\Columns\TextColumn::make('especialidade.nome')
                    ->label('Especialidade')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição'),
                    
                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Imprimir Encaminhamento')
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
