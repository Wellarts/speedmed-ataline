<?php

namespace App\Filament\Resources\AtendimentoClinicoNewResource\RelationManagers;

use App\Models\Exame;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SolicitacaoExameRelationManager extends RelationManager
{
    protected static string $relationship = 'SolicitacaoExames';

    protected static ?string $title = 'Solicitação de Exames';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('atendimento_clinico_id')
                    ->default((function ($livewire): int {
                        return $livewire->ownerRecord->id;
                    })),
                Forms\Components\Select::make('exames')
                    ->label('Exames Solicitados')
                    ->relationship('exames', 'nome')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->nome . ' (' . $record->tipo . ')')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if (!empty($state)) {
                            $exames = Exame::whereIn('id', $state)->pluck('nome')->map(function ($nome) {
                                return $nome . ':';
                            })->implode("\n");
                            $set('resultado', $exames);
                        }
                    })
                    ->preload()
                    ->searchable('nome')
                    ->multiple()
                    ->createOptionForm([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nome')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Forms\Components\Textarea::make('descricao')
                                    ->label('Descrição')
                                    ->maxLength(255),
                                Forms\Components\Select::make('tipo')
                                    ->label('Tipo')
                                    ->options([
                                        '1' => 'Laboratorial',
                                        '2' => 'Imagem',
                                    ])
                                    ->required()
                                    ->default('1'),
                            ]),
                    ]),
                       
                Forms\Components\Textarea::make('resultado')
                    ->autosize()
                    ->label('Resultado'),




            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('atendimento_clinico_id')
            ->columns([
                Tables\Columns\TextColumn::make('exames.nome')
                    ->listWithLineBreaks()
                    ->bulleted(),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Solicitar Exames')
                    ->modalHeading('Solicitar Exames')
                    ->icon('heroicon-o-plus')
                    ->createAnother(false)
                    ->disabled(fn($livewire) => $livewire->ownerRecord->solicitacaoExames()->count() > 0),
                Tables\Actions\Action::make('print')
                    ->label('Imprimir Exames')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn($livewire) => route('documentos.solicitacaoExames.print', $livewire->ownerRecord->id))
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
