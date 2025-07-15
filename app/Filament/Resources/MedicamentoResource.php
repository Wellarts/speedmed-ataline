<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicamentoResource\Pages;
use App\Filament\Resources\MedicamentoResource\RelationManagers;
use App\Models\Medicamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicamentoResource extends Resource
{
    protected static ?string $model = Medicamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationGroup = 'Cadastros';
    
    protected static ?string $navigationLabel = 'Medicamentos';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Informe o nome do medicamento'),
                Forms\Components\TextInput::make('principio_ativo')
                    ->label('Princípio Ativo')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Informe o princípio ativo do medicamento'),                    
                Forms\Components\Checkbox::make('alergia')
                    ->label('Alergia')
                    ->default(false)
                    ->helperText('Marque se o medicamento é comum em alergias'),
                Forms\Components\Checkbox::make('uso_continuo')
                    ->label('Uso Contínuo')
                    ->default(false)
                    ->helperText('Marque se o medicamento é usado continuamente'),
                Forms\Components\Checkbox::make('controle_especial')
                    ->label('Controle Especial')
                    ->default(false)
                    ->helperText('Marque se o medicamento é de controle especial'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('principio_ativo')
                    ->label('Princípio Ativo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('alergia')
                    ->label('Alergia')
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check')                    
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BooleanColumn::make('uso_continuo')
                    ->label('Uso Contínuo')
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check')                    
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\BooleanColumn::make('controle_especial')
                    ->label('Controle Especial')
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check')                   
                    ->sortable()
                    ->toggleable(),
                
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
            'index' => Pages\ManageMedicamentos::route('/'),
        ];
    }
}
