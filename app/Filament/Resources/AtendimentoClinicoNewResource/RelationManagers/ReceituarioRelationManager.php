<?php

namespace App\Filament\Resources\AtendimentoClinicoNewResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceituarioRelationManager extends RelationManager
{
    protected static string $relationship = 'Receituario';

    protected static ?string $title = 'Receituário';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Hidden::make('atendimento_clinico_id')
                            ->default((function ($livewire): int {
                                return $livewire->ownerRecord->id;
                            })),
                        Forms\Components\Select::make('medicamento_id')
                            ->relationship('medicamento', 'nome')
                            ->required()
                            ->searchable()
                            ->label('Medicamento')
                            ->createOptionForm([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('nome')
                                            ->label('Nome')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        Forms\Components\TextInput::make('principio_ativo')
                                            ->label('Princípio Ativo')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Checkbox::make('alergia')
                                            ->label('Alergia')
                                            ->default(false),
                                        Forms\Components\Checkbox::make('uso_continuo')
                                            ->label('Uso Contínuo')
                                            ->default(false),
                                        Forms\Components\Checkbox::make('controle_especial')
                                            ->label('Controle Especial')
                                            ->default(false),
                                    ]),
                                
                            ]),
                        Forms\Components\TextInput::make('qtd')
                            ->required()
                            ->placeholder('Ex: 10 compridos')
                            ->label('Quantidade'),
                        Forms\Components\TextInput::make('forma_uso')
                            ->label('Forma de Uso')
                            ->placeholder('Ex: 1 comprimido a cada 8 horas')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('atendimento_clinico_id')
            ->columns([
                Tables\Columns\TextColumn::make('medicamento.nome')
                    ->label('Medicamento'),
                Tables\Columns\TextColumn::make('medicamento.controle_especial')
                    ->label('Controle Especial')
                    ->alignCenter()
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Sim' : 'Não')
                    ->color(fn($state) => $state ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('qtd')
                    ->alignCenter()
                    ->label('Quantidade'),
                Tables\Columns\TextColumn::make('forma_uso')
                    ->label('Forma de Uso'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Adicionar Medicamento')
                    ->icon('heroicon-o-plus')
                    ->modalHeading('Adicionar Medicamento ao Receituário'),

                Tables\Actions\Action::make('print')
                    ->label('Imprimir Receituário Comum')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn($livewire) => route('documentos.receituarionew.print', $livewire->ownerRecord->id))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('printEspecial')
                    ->label('Imprimir Receituário Especial')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->url(fn($livewire) => route('documentos.receituarionewEspecial.print', $livewire->ownerRecord->id))
                    ->openUrlInNewTab()
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
