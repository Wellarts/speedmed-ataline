<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoencaResource\Pages;
use App\Filament\Resources\DoencaResource\RelationManagers;
use App\Models\Doenca;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoencaResource extends Resource
{
    protected static ?string $model = Doenca::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    
    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Doenças';
    
    protected static ?string $slug = 'doencas'; 
    
    protected static ?int $navigationSort = 3;    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cid')
                    ->label('CID')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                    Forms\Components\Toggle::make('grave')
                    ->label('Grave'),
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
                Tables\Columns\TextColumn::make('cid')
                    ->label('CID')
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\IconColumn::make('grave')
                    ->label('Grave')
                    ->boolean(),
                
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
            'index' => Pages\ManageDoencas::route('/'),
        ];
    }
}
