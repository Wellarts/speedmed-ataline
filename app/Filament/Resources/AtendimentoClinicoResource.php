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
use App\Models\Doenca;
use Filament\Forms\Set;

class AtendimentoClinicoResource extends Resource
{
    protected static ?string $model = AtendimentoClinico::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationGroup = 'Atendimentos';

    protected static ?string $navigationLabel = 'Atendimentos Clínicos';

    protected static string $modalWidth = 'full';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Dados do Paciente')
                    ->schema([
                        Forms\Components\Select::make('medico_id')
                            ->label('Médico')
                            ->relationship('medico', 'name')
                            ->default(auth()->user()->id)   
                            ->searchable()
                            ->required(),
                        
                        Forms\Components\Select::make('paciente_id')
                            ->label('Paciente')
                            ->relationship('paciente', 'nome')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nome')
                                    ->required(true)
                                    ->maxLength(100)


                                    ->label('Nome Completo')
                                    ->columnSpanFull(),
                                Forms\Components\Grid::make(['default' => 2, 'md' => 3])
                                    ->schema([
                                        Forms\Components\DatePicker::make('data_nascimento')
                                            ->required(false)
                                            ->label('Data de Nascimento'),
                                        Forms\Components\TextInput::make('cpf')
                                            ->required(false)
                                            ->maxLength(14)
                                            ->mask('999.999.999-99')
                                            ->unique(ignoreRecord: true)
                                            ->label('CPF')
                                            ->rule(function () {
                                                return function ($attribute, $value, $fail) {
                                                    $cpf = preg_replace('/\D/', '', $value);
                                                    if (strlen($cpf) !== 11) {
                                                        return $fail('O CPF deve conter 11 dígitos.');
                                                    }
                                                    if (preg_match('/(\d)\1{10}/', $cpf)) {
                                                        return $fail('CPF inválido.');
                                                    }
                                                    for ($t = 9; $t < 11; $t++) {
                                                        $d = 0;
                                                        for ($c = 0; $c < $t; $c++) {
                                                            $d += $cpf[$c] * (($t + 1) - $c);
                                                        }
                                                        $d = ((10 * $d) % 11) % 10;
                                                        if ($cpf[$c] != $d) {
                                                            return $fail('CPF inválido.');
                                                        }
                                                    }
                                                };
                                            }),
                                        Forms\Components\TextInput::make('rg')
                                            ->maxLength(20)
                                            ->nullable()
                                            ->label('RG'),
                                    ]),
                                Forms\Components\Grid::make(['default' => 2, 'md' => 3])
                                    ->schema([
                                        Forms\Components\Select::make('genero')
                                            ->options([
                                                1 => 'Masculino',
                                                2 => 'Feminino',
                                                3 => 'Outro',
                                            ])
                                            ->required(false)
                                            ->label('Gênero'),
                                        Forms\Components\Select::make('estado_civil')
                                            ->options([
                                                1 => 'Solteiro',
                                                2 => 'Casado',
                                                3 => 'Divorciado',
                                                4 => 'Viúvo',
                                            ])
                                            ->required(false)
                                            ->label('Estado Civil'),
                                        Forms\Components\TextInput::make('profissao')
                                            ->maxLength(100)
                                            ->nullable()
                                            ->label('Profissão'),
                                    ]),
                            ]),
                        Forms\Components\DateTimePicker::make('data_hora_atendimento')
                            ->label('Data/Hora do Atendimento')
                            ->default(now()->format('Y-m-d H:i:s'))
                            ->required(),
                        Forms\Components\ToggleButtons::make('status')
                            ->label('Status do Atendimento')
                            ->inline()
                            ->options([
                                '1' => 'Aberta',
                                '2' => 'Finalizada',
                                '0' => 'Cancelada',
                            ])
                            ->icons([
                                '1' => 'heroicon-o-check-circle',
                                '2' => 'heroicon-o-x-circle',
                                '0' => 'heroicon-o-exclamation-circle',
                            ])
                            ->colors([
                                '1' => 'info',
                                '2' => 'success',
                                '0' => 'danger',
                            ])
                            ->default('1')
                            ->required(),
                    ]),

                Forms\Components\Fieldset::make('Queixa Principal e História')
                    ->schema([
                        Forms\Components\Textarea::make('qp')
                            ->label('Queixa Principal')
                            ->autosize(),
                        Forms\Components\Textarea::make('hdp')
                            ->label('História da Doença Atual')
                            ->autosize(),
                        
                        Forms\Components\CheckboxList::make('doencas_preexistentes')
                            ->label('Doenças Preexistentes')
                            ->relationship('doenca', 'nome', fn($query) => $query->where('grave', 1))
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome . ' (CID: ' . $record->cid . ')')
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (is_array($state) && count($state)) {
                                    // Busca os nomes das doenças selecionadas
                                    $doencas = Doenca::whereIn('id', $state)->pluck('nome')->toArray();
                                    // Junta os nomes em uma string separada por quebra de linha
                                    $nomes = implode(' - '."\n", $doencas);
                                    // Seta o campo data_inicio_sintomas com os nomes das doenças
                                    $set('data_inicio_sintomas', $nomes.' - ');
                                } else {
                                    $set('data_inicio_sintomas', '');
                                }
                            })
                            ->searchable()
                            ->columns(2),                      
                        Forms\Components\TextArea::make('data_inicio_sintomas')
                              ->autosize()
                                 
                                 ->afterStateUpdated(function ($state, Set $set) {
                                     if (empty($state)) {
                                         $set('data_inicio_sintomas', 'Sem informação');
                                     }
                                 })
                              ->label('Data de Início dos Sintomas'),    
                        Forms\Components\Textarea::make('cirurgias_hospitalizacoes')
                            ->label('Cirurgias/Hospitalizações')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Alergias e Medicamentos')
                    ->schema([
                        Forms\Components\CheckboxList::make('medicamento_alergia')
                            ->label('Alergia Medicamentosa')
                            ->relationship('medicamentoAlergias', 'nome', fn($query) => $query->where('alergia', 1))
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome)
                            // ->live()
                            // ->afterStateUpdated(function ($state, Set $set) {
                            //     if (is_array($state) && count($state)) {
                            //         // Busca os nomes das medicamento selecionadas
                            //         $medicamento = Medicamento::whereIn('id', $state)->pluck('nome')->toArray();
                            //         // Junta os nomes em uma string separada por quebra de linha
                            //         $nomes = implode(' - '."\n", $medicamento);
                            //         // Seta o campo data_inicio_sintomas com os nomes das doenças
                            //         $set('data_inicio_sintomas', $nomes.' - ');
                            //     } else {
                            //         $set('data_inicio_sintomas', '');
                            //     }
                            // })
                            ->searchable()
                            ->columns(2), 
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
                Forms\Components\Textarea::make('observacoes')
                    ->label('Observações')
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