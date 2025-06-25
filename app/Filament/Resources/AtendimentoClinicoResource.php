<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtendimentoClinicoResource\Pages;
use App\Filament\Resources\AtendimentoClinicoResource\RelationManagers;
use App\Models\AtendimentoClinico;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtendimentoClinicoResource extends Resource
{
    protected static ?string $model = AtendimentoClinico::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Atendimentos Clínicos';

    

    public static function form(Form $form): Form
    {
        return $form
            ->modalWidth(MaxWidth::FiveExtraLarge)
            ->schema([
                Forms\Components\Fieldset::make('Dados do Paciente')
                    ->schema([
                        Forms\Components\Select::make('paciente_id')
                            ->label('Paciente')
                            ->relationship('paciente', 'nome')
                            ->searchable()
                            ->required(),
                        Forms\Components\DateTimePicker::make('data_hora_atendimento')
                            ->label('Data/Hora do Atendimento')
                            ->required(),
                        Forms\Components\Select::make('medico_id')
                            ->label('Médico')
                            ->relationship('medico', 'nome')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('tipo_atendimento')
                            ->label('Tipo de Atendimento')
                            ->options([
                                'consulta' => 'Consulta',
                                'retorno' => 'Retorno',
                                'emergencia' => 'Emergência',
                                // Adicione outros tipos conforme necessário
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('observacoes')
                            ->label('Observações'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'aberto' => 'Aberto',
                                'finalizado' => 'Finalizado',
                                'cancelado' => 'Cancelado',
                            ])
                            ->required(),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Queixa Principal e História')
                    ->schema([
                        Forms\Components\Textarea::make('qp')
                            ->label('Queixa Principal')
                            ->rows(2),
                        Forms\Components\Textarea::make('hdp')
                            ->label('História da Doença Atual')
                            ->rows(2),
                        Forms\Components\Select::make('doenca_id')
                            ->label('Doença')
                            ->relationship('doenca', 'nome')
                            ->searchable(),
                        Forms\Components\DatePicker::make('data_inicio_sintomas')
                            ->label('Data de Início dos Sintomas'),
                        Forms\Components\Textarea::make('cirurgias_hospitalizacoes')
                            ->label('Cirurgias/Hospitalizações')
                            ->rows(2),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Alergias e Medicamentos')
                    ->schema([
                        Forms\Components\Select::make('medicamento_alergias_id')
                            ->label('Alergias a Medicamentos')
                            ->relationship('medicamentoAlergias', 'nome')
                            ->searchable()
                            ->multiple(),
                        Forms\Components\TextInput::make('alimento_alergias')
                            ->label('Alergias Alimentares'),
                        Forms\Components\TextInput::make('outros_alergias')
                            ->label('Outras Alergias'),
                        Forms\Components\Select::make('medicamento_uso_id')
                            ->label('Medicamentos em Uso')
                            ->relationship('medicamentoUso', 'nome')
                            ->searchable()
                            ->multiple(),
                        Forms\Components\Textarea::make('medicamento_uso_detalhes')
                            ->label('Detalhes dos Medicamentos em Uso')
                            ->rows(2),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Histórico Familiar')
                    ->schema([
                        Forms\Components\Select::make('doenca_familiar_id')
                            ->label('Doenças Familiares')
                            ->relationship('doencaFamiliar', 'nome')
                            ->searchable()
                            ->multiple(),
                        Forms\Components\TextInput::make('doenca_familiar_parentesco')
                            ->label('Parentesco'),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Estilo de Vida')
                    ->schema([
                        Forms\Components\Select::make('tabagismo')
                            ->label('Tabagismo')
                            ->options([
                                'nao' => 'Não',
                                'sim' => 'Sim',
                                'ex' => 'Ex',
                            ]),
                        Forms\Components\Select::make('alcoolismo')
                            ->label('Alcoolismo')
                            ->options([
                                'nao' => 'Não',
                                'sim' => 'Sim',
                                'ex' => 'Ex',
                            ]),
                        Forms\Components\Select::make('drogas')
                            ->label('Drogas')
                            ->options([
                                'nao' => 'Não',
                                'sim' => 'Sim',
                                'ex' => 'Ex',
                            ]),
                        Forms\Components\TextInput::make('atividade_fisica')
                            ->label('Atividade Física'),
                        Forms\Components\TextInput::make('dieta')
                            ->label('Dieta'),
                        Forms\Components\Textarea::make('obs_estilo_vida')
                            ->label('Observações sobre Estilo de Vida')
                            ->rows(2),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Exame Físico')
                    ->schema([
                        Forms\Components\DatePicker::make('dum')
                            ->label('DUM'),
                        Forms\Components\TextInput::make('pa')
                            ->label('PA'),
                        Forms\Components\TextInput::make('peso')
                            ->label('Peso'),
                        Forms\Components\TextInput::make('altura')
                            ->label('Altura'),
                        Forms\Components\TextInput::make('imc')
                            ->label('IMC'),
                        Forms\Components\TextInput::make('fc')
                            ->label('FC'),
                        Forms\Components\TextInput::make('fr')
                            ->label('FR'),
                        Forms\Components\TextInput::make('temperatura')
                            ->label('Temperatura'),
                        Forms\Components\TextInput::make('saturacao')
                            ->label('Saturação'),
                        Forms\Components\Textarea::make('obs_exame_fisico')
                            ->label('Observações do Exame Físico')
                            ->rows(2),
                        Forms\Components\Textarea::make('exame_fisico')
                            ->label('Exame Físico Detalhado')
                            ->rows(2),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Diagnóstico e Conduta')
                    ->schema([
                        Forms\Components\Select::make('hipotese_diagnostica_id')
                            ->label('Hipótese Diagnóstica')
                            ->relationship('hipoteseDiagnostica', 'nome')
                            ->searchable()
                            ->multiple(),
                        Forms\Components\Textarea::make('hipotese_diagnostica_detalhes')
                            ->label('Detalhes da Hipótese Diagnóstica')
                            ->rows(2),
                        Forms\Components\Textarea::make('prescricao_medicamentosa')
                            ->label('Prescrição Medicamentosa')
                            ->rows(2),
                        Forms\Components\Textarea::make('exames_solicitados')
                            ->label('Exames Solicitados')
                            ->rows(2),
                        Forms\Components\Textarea::make('encaminhamentos')
                            ->label('Encaminhamentos')
                            ->rows(2),
                        Forms\Components\Textarea::make('orientacoes')
                            ->label('Orientações')
                            ->rows(2),
                        Forms\Components\Textarea::make('evolucao')
                            ->label('Evolução')
                            ->rows(2),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Anexos')
                    ->schema([
                        Forms\Components\FileUpload::make('anexos_resultados')
                            ->label('Anexos/Resultados')
                            ->multiple(),
                    ])
                    ->columnSpanFull(),
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
            'index' => Pages\ManageAtendimentoClinicos::route('/'),
        ];
    }
}
