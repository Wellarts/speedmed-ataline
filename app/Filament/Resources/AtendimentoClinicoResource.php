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
use App\Models\Medicamento;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;


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
                            ->relationship('medico', 'nome')
                            ->default(auth()->user()->id)   
                            ->searchable()
                            ->required(),
                        
                        Forms\Components\Select::make('paciente_id')
                            ->label('Paciente')
                            ->relationship('paciente', 'nome')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                $paciente = $get('paciente_id');
                                $set('paciente', $paciente);
                                
                                $ultimoAtendimento = AtendimentoClinico::where('paciente_id', $paciente)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                                
                                if ($ultimoAtendimento) {
                                    Notification::make()
                                        ->title('Último atendimento')
                                        ->body('<b>Data</b>: ' . $ultimoAtendimento->data_hora_atendimento->format('d/m/Y') .'<br>
                                        <b>Queixa principal</b>: ' . $ultimoAtendimento->qp.'<br>
                                        <br><b>História Clínica</b>: ' . $ultimoAtendimento->hdp .'<br>'                                        
                                        
                                        
                                        )
                                        ->info()
                                        ->persistent()
                                        ->send();
                                }
                            })                            
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
                                '1' => 'Iniciada',
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
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                // Recupera o valor atual do campo
                                $valorAtual = $get('data_inicio_sintomas') ?? '';

                                if (is_array($state) && count($state)) {
                                    // Busca os nomes das doenças selecionadas
                                    $doencas = Doenca::whereIn('id', $state)->pluck('nome')->toArray();
                                    // Junta os nomes em uma string, cada um em uma linha terminando com " -"
                                    $novasLinhas = array_map(fn($nome) => trim($nome) . ' - ', $doencas);

                                    // Quebra o valor atual em linhas e remove espaços extras
                                    $linhasExistentes = array_map('trim', explode("\n", $valorAtual));

                                    // Adiciona apenas as linhas que ainda não existem (comparando até o " -")
                                    foreach ($novasLinhas as $linha) {
                                        $existe = false;
                                        $parteLinha = strtolower(trim(strtok($linha, '-')));
                                        foreach ($linhasExistentes as $existente) {
                                            $parteExistente = strtolower(trim(strtok($existente, '-')));
                                            if ($parteLinha === $parteExistente) {
                                                $existe = true;
                                                break;
                                            }
                                        }
                                        if ($linha && !$existe) {
                                            $linhasExistentes[] = $linha;
                                        }
                                    }

                                    // Atualiza o campo com todas as linhas únicas
                                    $set('data_inicio_sintomas', implode("\n", array_filter($linhasExistentes)));
                                }
                            }),

                                      
                                       
                        Forms\Components\TextArea::make('data_inicio_sintomas')
                              ->autosize()     
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
                            ->searchable()
                            ->columns(2), 
                        Forms\Components\TextArea::make('outros_alergias')
                            ->autosize()
                            ->label('Outras Alergias'),
                         Forms\Components\CheckboxList::make('medicamento_uso')
                            ->label('Medicamentos em Uso Contínuo')
                            ->relationship('medicamentoUso', 'nome', fn($query) => $query->where('uso_continuo', 1))
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome)
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                // Recupera o valor atual do campo
                                $valorAtual = $get('medicamento_uso_detalhes') ?? '';

                                if (is_array($state) && count($state)) {
                                    // Busca os nomes das doenças selecionadas
                                    $medicamento = Medicamento::whereIn('id', $state)->pluck('nome')->toArray();
                                    // Junta os nomes em uma string, cada um em uma linha terminando com " -"
                                    $novasLinhas = array_map(fn($nome) => trim($nome) . ' - ', $medicamento);

                                    // Quebra o valor atual em linhas e remove espaços extras
                                    $linhasExistentes = array_map('trim', explode("\n", $valorAtual));

                                    // Adiciona apenas as linhas que ainda não existem (comparando até o " -")
                                    foreach ($novasLinhas as $linha) {
                                        $existe = false;
                                        $parteLinha = strtolower(trim(strtok($linha, '-')));
                                        foreach ($linhasExistentes as $existente) {
                                            $parteExistente = strtolower(trim(strtok($existente, '-')));
                                            if ($parteLinha === $parteExistente) {
                                                $existe = true;
                                                break;
                                            }
                                        }
                                        if ($linha && !$existe) {
                                            $linhasExistentes[] = $linha;
                                        }
                                    }

                                    // Atualiza o campo com todas as linhas únicas
                                    $set('medicamento_uso_detalhes', implode("\n", array_filter($linhasExistentes)));
                                }
                            })

                            ->searchable()
                            ->columns(2), 
                        Forms\Components\Textarea::make('medicamento_uso_detalhes')
                            ->label('Detalhes dos Medicamentos em Uso')
                            ->autosize(),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Histórico Familiar')
                    ->schema([
                        Forms\Components\CheckboxList::make('doencas_familiares')
                            ->label('Doenças em Famíliares')
                            ->relationship('doencaFamiliar', 'nome', fn($query) => $query->where('grave', 1))
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome . ' (CID: ' . $record->cid . ')')
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                // Recupera o valor atual do campo
                                $valorAtual = $get('doenca_familiar_parentesco') ?? '';

                                if (is_array($state) && count($state)) {
                                    // Busca os nomes das doenças selecionadas
                                    $doencas = Doenca::whereIn('id', $state)->pluck('nome')->toArray();
                                    // Junta os nomes em uma string, cada um em uma linha terminando com " -"
                                    $novasLinhas = array_map(fn($nome) => trim($nome) . ' - ', $doencas);

                                    // Quebra o valor atual em linhas e remove espaços extras
                                    $linhasExistentes = array_map('trim', explode("\n", $valorAtual));

                                    // Adiciona apenas as linhas que ainda não existem (comparando até o " -")
                                    foreach ($novasLinhas as $linha) {
                                        $existe = false;
                                        $parteLinha = strtolower(trim(strtok($linha, '-')));
                                        foreach ($linhasExistentes as $existente) {
                                            $parteExistente = strtolower(trim(strtok($existente, '-')));
                                            if ($parteLinha === $parteExistente) {
                                                $existe = true;
                                                break;
                                            }
                                        }
                                        if ($linha && !$existe) {
                                            $linhasExistentes[] = $linha;
                                        }
                                    }

                                    // Atualiza o campo com todas as linhas únicas
                                    $set('doenca_familiar_parentesco', implode("\n", array_filter($linhasExistentes)));
                                }
                            })
                            ->searchable()
                            ->columns(2),                      
                        Forms\Components\TextArea::make('doenca_familiar_parentesco')
                              ->autosize()   
                              ->label('Doenças na Família e Parentesco'), 
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Estilo de Vida')
                    ->schema([
                        Forms\Components\ToggleButtons::make('tabagismo')
                            ->label('Tabagismo')
                            ->boolean()
                            ->grouped()
                            ->default(false)
                            ->inline(false),
                        Forms\Components\ToggleButtons::make('alcoolismo')
                            ->label('Alcoolismo')
                            ->boolean()
                            ->default(false)
                            ->grouped()
                            ->inline(false),
                        Forms\Components\ToggleButtons::make('drogas')
                            ->label('Drogas')
                            ->boolean()
                            ->default(false)
                            ->grouped()
                            ->inline(false),
                        Forms\Components\ToggleButtons::make('atividade_fisica')
                            ->label('Atividade Física')
                            ->boolean()
                            ->default(false)
                            ->grouped()
                            ->inline(false),
                        Forms\Components\ToggleButtons::make('dieta')
                            ->label('Dieta')
                            ->boolean()
                            ->default(false)
                            ->grouped()
                            ->inline(false),
                        Forms\Components\Textarea::make('obs_estilo_vida')
                            ->label('Observações sobre Estilo de Vida')
                            ->autosize(),
                           // ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                        'md' => 2,
                        'lg' => 2,
                        'xl' => 2,
                        '2xl' => 2,                    
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Exame Físico')
                    ->schema([
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'sm' => 2,
                            'md' => 3,
                            'lg' => 4,
                        ])->schema([
                            Forms\Components\DatePicker::make('dum')
                                ->label('DUM'),
                            Forms\Components\TextInput::make('pa')
                                ->label('PA(mmHg)'),
                            Forms\Components\TextInput::make('peso')
                                ->label('Peso')
                                ->hint('kg' . ' (Ex: 70.5)')
                                ->numeric()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, Set $set, $get) {
                                    $peso = floatval($state);
                                    $altura = floatval($get('altura'));
                                    if ($peso > 0 && $altura > 0) {
                                        $imc = $peso / ($altura * $altura);
                                        $set('imc', number_format($imc, 2, '.', ''));
                                    }
                                }),
                            Forms\Components\TextInput::make('altura')
                                ->label('Altura')
                                ->numeric()
                                ->hint('m' . ' (Ex: 1.75)')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function ($state, Set $set, $get) {
                                    $altura = floatval($state);
                                    $peso = floatval($get('peso'));
                                    if ($peso > 0 && $altura > 0) {
                                        $imc = $peso / ($altura * $altura);
                                        $set('imc', number_format($imc, 2, '.', ''));
                                    }
                                }),
                            Forms\Components\TextInput::make('imc')
                                ->readOnly()
                                ->label('IMC')
                                ->suffix(function ($state) {
                                    $imc = floatval($state);
                                    if ($imc > 0 && $imc < 18) {
                                        return ' 🟨'; // amarelo
                                    } elseif ($imc >= 18.5 && $imc <= 24.9) {
                                        return '🟩';
                                    } elseif ($imc >= 25 && $imc <= 29.9) {
                                        return '🟧';
                                    } elseif ($imc > 29.9) {
                                        return '🟥';
                                    }
                                    return '';
                                })
                                ->extraAttributes(function ($state) {
                                    $imc = floatval($state);
                                    if ($imc > 0 && $imc < 18) {
                                        return ['style' => 'color: #eab308; font-weight: bold;']; // amarelo
                                    } elseif ($imc >= 18.5 && $imc <= 24.9) {
                                        return ['style' => 'color: #22c55e; font-weight: bold;']; // verde
                                    } elseif ($imc >= 25 && $imc <= 29.9) {
                                        return ['style' => 'color: #f97316; font-weight: bold;']; // laranja
                                    } elseif ($imc > 29.9) {
                                        return ['style' => 'color: #ef4444; font-weight: bold;']; // vermelho
                                    }
                                    return [];
                                }),
                            Forms\Components\TextInput::make('fc')
                                ->label('FC (bpm)'),                                
                            Forms\Components\TextInput::make('fr')
                                ->label('FR (/min)'),
                            Forms\Components\TextInput::make('temperatura')
                                ->label('Temperatura (°C)'),
                            Forms\Components\TextInput::make('saturacao')
                                ->label('Saturação  (%)'),
                        ]),
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])->schema([
                            Forms\Components\Textarea::make('obs_exame_fisico')
                                ->label('Observações do Exame Físico')
                                ->columnSpan(3)
                                ->autosize(),
                            
                        ]),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Fieldset::make('Diagnóstico e Conduta')
                    ->schema([
                        Forms\Components\Select::make('hipotese_diagnostica_id')
                            ->label('Hipótese Diagnóstica')
                            ->relationship('hipoteseDiagnostica', 'nome')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome . ' (CID: ' . $record->cid . ')')
                            ->required()
                            ->preload()
                            ->searchable(['nome', 'cid'])
                            ->multiple(),

                        Forms\Components\Textarea::make('hipotese_diagnostica_detalhes')
                            ->label('Detalhes da Hipótese Diagnóstica')
                            ->autosize(),
                        Forms\Components\Select::make('exames_id')
                            ->label('Exames Solicitados')
                            ->relationship('exames', 'nome')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome . ' (' . $record->tipo . ')')
                            ->required()
                            ->preload()
                            ->searchable('nome')
                            ->multiple()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                // Recupera o valor atual do campo resultados_exames
                                $valorAtual = $get('resultados_exames') ?? '';

                                if (is_array($state) && count($state)) {
                                    // Busca os exames selecionados com nome e tipo
                                    $exames = \App\Models\Exame::whereIn('id', $state)->get(['nome', 'tipo']);
                                    // Junta nome e tipo em uma string, cada um em uma linha: "NOME (TIPO) -"
                                    $novasLinhas = [];
                                    foreach ($exames as $exame) {
                                        $linha = trim($exame->nome) . ' (' . trim($exame->tipo) . ') - ';
                                        $novasLinhas[] = $linha;
                                    }

                                    // Quebra o valor atual em linhas e remove espaços extras
                                    $linhasExistentes = array_map('trim', explode("\n", $valorAtual));

                                    // Adiciona apenas as linhas que ainda não existem (comparando até o " -")
                                    foreach ($novasLinhas as $linha) {
                                        $existe = false;
                                        $parteLinha = strtolower(trim(strtok($linha, '-')));
                                        foreach ($linhasExistentes as $existente) {
                                            $parteExistente = strtolower(trim(strtok($existente, '-')));
                                            if ($parteLinha === $parteExistente) {
                                                $existe = true;
                                                break;
                                            }
                                        }
                                        if ($linha && !$existe) {
                                            $linhasExistentes[] = $linha;
                                        }
                                    }

                                    // Atualiza o campo com todas as linhas únicas
                                    $set('resultados_exames', implode("\n", array_filter($linhasExistentes)));
                                }
                            }),
                        Forms\Components\Textarea::make('resultados_exames')
                            ->label('Resultados dos Exames')
                            ->autosize(),
                        Forms\Components\Select::make('medicamentos_id')
                            ->label('Prescrição Medicamentosa')
                            ->relationship('medicamentos', 'nome')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome . ' (' . $record->principio_ativo . ')')
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, $get) {
                                // Recupera o valor atual do campo medicamentos_detalhes
                                $valorAtual = $get('medicamentos_detalhes') ?? '';

                                if (is_array($state) && count($state)) {
                                    // Busca os nomes dos medicamentos selecionados
                                    $medicamentos = \App\Models\Medicamento::whereIn('id', $state)->pluck('nome')->toArray();
                                    // Junta os nomes em uma string, cada um em uma linha terminando com " -"
                                    $novasLinhas = array_map(fn($nome) => trim($nome) . ' - ', $medicamentos);

                                    // Quebra o valor atual em linhas e remove espaços extras
                                    $linhasExistentes = array_map('trim', explode("\n", $valorAtual));

                                    // Adiciona apenas as linhas que ainda não existem (comparando até o " -")
                                    foreach ($novasLinhas as $linha) {
                                        $existe = false;
                                        $parteLinha = strtolower(trim(strtok($linha, '-')));
                                        foreach ($linhasExistentes as $existente) {
                                            $parteExistente = strtolower(trim(strtok($existente, '-')));
                                            if ($parteLinha === $parteExistente) {
                                                $existe = true;
                                                break;
                                            }
                                        }
                                        if ($linha && !$existe) {
                                            $linhasExistentes[] = $linha;
                                        }
                                    }

                                    // Atualiza o campo com todas as linhas únicas
                                    $set('medicamentos_detalhes', implode("\n", array_filter($linhasExistentes)));
                                }
                            })
                            ->required()
                            ->preload()
                            ->searchable(['nome', 'principio_ativo'])
                            ->multiple(),
                        Forms\Components\Textarea::make('medicamentos_detalhes')
                            ->label('Detalhes da Medicação Prescrita')
                            ->autosize(),
                        
                        Forms\Components\Select::make('encaminhamentos_id')
                            ->label('Encaminhamentos')
                            ->relationship('encaminhamentos', 'nome')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nome)
                            ->required()
                            ->preload()
                            ->searchable('nome')
                            ->multiple(),
                        
                        Forms\Components\Textarea::make('evolucao')
                            ->label('Evolução')
                            ->autosize(),
                        Forms\Components\Textarea::make('orientacoes')
                            ->label('Demais Orientações')
                            ->autosize(),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Anexos')
                    ->schema([
                        Forms\Components\FileUpload::make('anexos_resultados')
                            ->label('Anexos/Resultados')
                            ->directory('atendimentos/anexos')
                            ->multiple(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paciente.nome')
                    ->label('Paciente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_hora_atendimento')
                    ->label('Data/Hora do Atendimento')
                    ->alignCenter()
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->alignCenter()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        '1' => 'Iniciada',
                        '2' => 'Finalizada',
                        '0' => 'Cancelada',
                    })
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '0' => 'danger',
                    })
                    ->icon(fn ($state) => match ($state) {
                        '1' => 'heroicon-o-check-circle',
                        '2' => 'heroicon-o-x-circle',
                        '0' => 'heroicon-o-exclamation-circle',
                    })
                    ->sortable()
                    ->searchable()
                    
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        '1' => 'Iniciada',
                        '2' => 'Finalizada',
                        '0' => 'Cancelada',
                    ])
                    ->label('Status'),
                SelectFilter::make('paciente_id')
                    ->relationship('paciente', 'nome')
                    ->label('Paciente'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Prontuário')
                        ->icon('heroicon-o-document-text')
                        ->url(fn (AtendimentoClinico $record) => route('documentos.prontuario', $record))
                        ->openUrlInNewTab(),
                Tables\Actions\Action::make('receituario') 
                        ->icon('heroicon-o-document-text')
                        ->url(fn (AtendimentoClinico $record) => route('documentos.receituarioComum', $record))
                        ->openUrlInNewTab(),
                ])
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