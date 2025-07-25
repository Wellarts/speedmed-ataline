<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentoResource\Pages;
use App\Filament\Resources\DocumentoResource\RelationManagers;
use App\Models\Documento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentoResource extends Resource
{
    protected static ?string $model = Documento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Declarações/Outros';

    protected static string $modalWidth = 'full';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipo')
                            ->label('Tipo de Documento')
                            ->options([
                                '1' => 'Declaração de Comparecimento',
                                '2' => 'Atestado',
                                '3' => 'Receituário',
                                '4' => 'Encaminhamento',
                                '5' => 'exames',
                                '6' => 'Orientações',
                                '7' => 'Outros',
                            ])
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                if ($state === '1') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Declaração de Comparecimento</strong></div>');
                                } elseif ($state === '2') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Atestado Médico</strong></div>');
                                } elseif ($state === '3') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Receituário Médico</strong></div>');
                                } elseif ($state === '4') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Encaminhamento Médico</strong></div>');
                                } elseif ($state === '5') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Exames Médicos</strong></div>');
                                } elseif ($state === '6') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Orientações Médicas</strong></div>');
                                } elseif ($state === '7') {
                                    $set('descricao', '<div style="text-align:center;"><strong>Outros Documentos</strong></div>');
                                }
                                
                            })
                           
                            ->default('1')
                            ->required(),
                    
                Forms\Components\Select::make('paciente_id')
                    ->relationship('paciente', 'nome')
                    ->required(),
                Forms\Components\DateTimePicker::make('data_hora')
                    ->label('Data e Hora')
                     ->default(now()->format('Y-m-d H:i:s'))                                
                    ->required(),
                Forms\Components\MarkdownEditor::make('descricao')
                    ->columnSpanFull()
                    // ->disableToolbarButtons([
                    //         'attachFiles'
                    //     ])
                    ->toolbarButtons([
        'attachFiles',
        'blockquote',
        'bold',
        'bulletList',
        'codeBlock',
        'h2',
        'h3',
        'italic',
        'link',
        'orderedList',
        'redo',
        'strike',
        'underline',
        'undo',
    ])
                    ->label('Descrição'),
                        
                    ]);
                   
           
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDocumentos::route('/'),
        ];
    }
}
