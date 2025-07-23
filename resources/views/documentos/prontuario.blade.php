<!DOCTYPE html>
<html>

<head>
    <title>Prontuário Médico</title>
    <style>
        :root {
            --primary-color: #ac2b38;
            --secondary-color: #6c757d;
            --success-color: #4CAF50;
            --info-color: #2196F3;
            --warning-color: #FFC107;
            --danger-color: #F44336;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-color: #e9ecef;
            --section-bg: #f8f9fa;
        }

        body {
            font-family: 'Roboto', 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;

            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;

            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            page-break-after: always;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-right {
            text-align: right;
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            font-size: 10pt;
            background: var(--section-bg);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .section h2 {
            margin-top: 0;
            color: var(--primary-color);
            font-size: 1.0rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .fields-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 15px;
        }

        .field {
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
        }

        .label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 3px;
            font-size: 0.9rem;
        }

        .value {
            color: var(--secondary-color);

            padding: 6px 10px;
            border-radius: 4px;

            min-height: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .status-iniciada {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info-color);
        }

        .status-finalizada {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .status-cancelada {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
        }

        table th {
            background-color: var(--light-color);
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .signature-area {
            margin-top: 0px;
            text-align: center;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 15px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin: 0 auto;
            padding-top: 5px;
        }

        @page {
            margin: 1cm;
            size: A4 portrait;
        }

        @media (max-width: 900px) {
            .fields-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Estilos para impressão */
        @media print {
            body {
                background: white;
            }

            .container {
                box-shadow: none;
                padding: 0;
            }

            .section {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="width: 100%; margin-bottom: 10px; border-bottom: 1px solid var(--border-color);">
            <tr>
                <td style="width: 20%; vertical-align: middle; padding-bottom: 10px;">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 120px;">
                </td>
                <td style="width: 80%; vertical-align: middle; text-align: right; padding-bottom: 10px;">
                    <h1 style="margin: 0; color: var(--dark-color); font-size: 1.4rem;">Prontuário Médico</h1>
                    <h3 style="margin: 3px 0; color: var(--secondary-color); font-size: 1rem;">Paciente:
                        {{ $prontuario->paciente->nome }}</h3>
                    <span style="margin-left: 10px; additive-symbols: none; color: var(--secondary-color);">
                        Data/hora do atendimento:
                        {{ \Carbon\Carbon::parse($prontuario->data_hora_atendimento)->format('d/m/Y H:i') }}
                    </span>

                </td>
            </tr>
        </table>



        <div class="section">
            <h2>Informações do Paciente</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="field full-width">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2" style="padding: 2px 4px;">
                                    <span class="label">Nome:</span>
                                    <span class="value">{{ $prontuario->paciente->nome }}</span>
                                </td>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Data de Nascimento:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->data_nascimento ? \Carbon\Carbon::parse($prontuario->paciente->data_nascimento)->format('d/m/Y') : 'Não informado' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 33%; padding: 2px 4px;">
                                    <span class="label">CPF:</span>
                                    <span class="value">{{ $prontuario->paciente->cpf }}</span>
                                </td>
                                <td style="width: 33%; padding: 2px 4px;">
                                    <span class="label">RG:</span>
                                    <span class="value">{{ $prontuario->paciente->rg ?? 'Não informado' }}</span>
                                </td>
                                <td style="width: 33%; padding: 2px 4px;">
                                    <span class="label">Gênero:</span>
                                    <span class="value">{{ $prontuario->paciente->genero  }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Estado Civil:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->estado_civil ?? 'Não informado' }}</span>
                                </td>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Telefone:</span>
                                    <span class="value">{{ $prontuario->paciente->telefone ?? 'Não informado' }}</span>
                                </td>
                                <td style="padding: 2px 4px;">
                                    <span class="label">E-mail:</span>
                                    <span class="value">{{ $prontuario->paciente->email ?? 'Não informado' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Profissão:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->profissao ?? 'Não informado' }}</span>
                                </td>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Convênio:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->convenio ?? 'Não informado' }}</span>
                                </td>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Contato de Emergência:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->contato_emergencia ?? 'Não informado' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Grau de Parentesco:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->grau_parentesco ?? 'Não informado' }}</span>
                                </td>
                                <td colspan="2" style="padding: 2px 4px;"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding: 2px 4px;">
                                    <span class="label">Endereço Completo:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->endereco_completo ?? 'Não informado' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Cidade:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->cidade->nome ?? 'Não informado' }}</span>
                                </td>
                                <td style="padding: 2px 4px;">
                                    <span class="label">Estado:</span>
                                    <span
                                        class="value">{{ $prontuario->paciente->estado->nome ?? 'Não informado' }}</span>
                                </td>
                                <td style="padding: 2px 4px;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Avaliação Médica</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="field full-width">
                    <span class="label">Queixa Principal:</span>
                    <span class="value">{{ $prontuario->qp }}</span>
                </div>
                <div class="field full-width">
                    <span class="label">História da Doença Atual:</span>
                    <span class="value">{{ $prontuario->hdp }}</span>
                </div>

                <div class="field">
                    <span class="label">Data de Início dos Sintomas:</span>
                    <span class="value">{{ $prontuario->data_inicio_sintomas ?? 'Não informado' }}</span>
                </div>
                <div class="field">
                    <span class="label">Doenças Preexistentes:</span>
                    <span class="value">
                        @if ($prontuario->doenca && $prontuario->doenca->count())
                            {{ $prontuario->doenca->pluck('nome')->implode(', ') }}
                        @else
                            Nenhuma
                        @endif
                    </span>
                </div>

                <div class="field">
                    <span class="label">Alergia Medicamentosa:</span>
                    <span class="value">
                        @if ($prontuario->medicamentoAlergias && $prontuario->medicamentoAlergias->count())
                            {{ $prontuario->medicamentoAlergias->pluck('nome')->implode(', ') }}
                        @else
                            Nenhuma
                        @endif
                    </span>
                </div>
                <div class="field">
                    <span class="label">Outras Alergias:</span>
                    <span class="value">{{ $prontuario->outros_alergias ?? 'Não informado' }}</span>
                </div>

                <div class="field">
                    <span class="label">Cirurgias/Hospitalizações:</span>
                    <span class="value">{{ $prontuario->cirurgias_hospitalizacoes ?? 'Não informado' }}</span>
                </div>
                <div class="field">
                    <span class="label">Medicamentos em Uso Contínuo:</span>
                    <span class="value">
                        @if ($prontuario->medicamentoUso && $prontuario->medicamentoUso->count())
                            {{ $prontuario->medicamentoUso->pluck('nome')->implode(', ') }}
                        @else
                            Nenhum
                        @endif
                    </span>
                </div>

                <div class="field full-width">
                    <span class="label">Detalhes dos Medicamentos em Uso:</span>
                    <span class="value">{{ $prontuario->medicamento_uso_detalhes ?? 'Não informado' }}</span>
                </div>

                <div class="field">
                    <span class="label">Doenças Familiares:</span>
                    <span class="value">
                        @if ($prontuario->doencaFamiliar && $prontuario->doencaFamiliar->count())
                            {{ $prontuario->doencaFamiliar->pluck('nome')->implode(', ') }}
                        @else
                            Nenhuma
                        @endif
                    </span>
                </div>
                <div class="field">
                    <span class="label">Parentesco das Doenças Familiares:</span>
                    <span class="value">{{ $prontuario->doenca_familiar_parentesco ?? 'Não informado' }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Estilo de Vida</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(3, 1fr);">
                <div class="field">
                    <span class="label">DUM:</span>
                    <span
                        class="value">{{ $prontuario->dum ? \Carbon\Carbon::parse($prontuario->dum)->format('d/m/Y') : 'Não informado' }}</span>
                </div>
                <div class="field">
                    <span class="label">Tabagismo:</span>
                    <span
                        class="value">{{ $prontuario->tabagismo == 1 ? 'Sim' : ($prontuario->tabagismo === 0 ? 'Não' : $prontuario->tabagismo) }}</span>
                </div>
                <div class="field">
                    <span class="label">Alcoolismo:</span>
                    <span
                        class="value">{{ $prontuario->alcoolismo == 1 ? 'Sim' : ($prontuario->alcoolismo === 0 ? 'Não' : $prontuario->alcoolismo) }}</span>
                </div>
                <div class="field">
                    <span class="label">Drogas:</span>
                    <span
                        class="value">{{ $prontuario->drogas == 1 ? 'Sim' : ($prontuario->drogas === 0 ? 'Não' : $prontuario->drogas) }}</span>
                </div>
                <div class="field">
                    <span class="label">Atividade Física:</span>
                    <span
                        class="value">{{ $prontuario->atividade_fisica == 1 ? 'Sim' : ($prontuario->atividade_fisica === 0 ? 'Não' : $prontuario->atividade_fisica) }}</span>
                </div>
                <div class="field">
                    <span class="label">Dieta:</span>
                    <span
                        class="value">{{ $prontuario->dieta == 1 ? 'Sim' : ($prontuario->dieta === 0 ? 'Não' : $prontuario->dieta) }}</span>
                </div>
                <div class="field full-width">
                    <span class="label">Observações Estilo de Vida:</span>
                    <span class="value">{{ $prontuario->obs_estilo_vida }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Dados Vitais</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(4, 1fr);">
                <div class="field">
                    <span class="label">Pressão Arterial:</span>
                    <span class="value">{{ $prontuario->pa }}</span>
                </div>
                <div class="field">
                    <span class="label">Frequência Cardíaca:</span>
                    <span class="value">{{ $prontuario->fc }}</span>
                </div>
                <div class="field">
                    <span class="label">Frequência Respiratória:</span>
                    <span class="value">{{ $prontuario->fr }}</span>
                </div>
                <div class="field">
                    <span class="label">Temperatura:</span>
                    <span class="value">{{ $prontuario->temperatura }}°C</span>
                </div>
                <div class="field">
                    <span class="label">Saturação:</span>
                    <span class="value">{{ $prontuario->saturacao }}%</span>
                </div>
                <div class="field">
                    <span class="label">Peso:</span>
                    <span class="value">{{ $prontuario->peso }} kg</span>
                </div>
                <div class="field">
                    <span class="label">Altura:</span>
                    <span class="value">{{ $prontuario->altura }} m</span>
                </div>
                <div class="field">
                    <span class="label">IMC:</span>
                    <span class="value">{{ $prontuario->imc }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Exame Físico</h2>
            <div class="fields-grid">
                <div class="field">
                    <span class="label">Observações Exame Físico:</span>
                    <span class="value">{{ $prontuario->obs_exame_fisico ?? 'Não informado' }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Hipótese Diagnóstica</h2>
            <div class="fields-grid">
                <div class="field">
                    <span class="label">Hipótese Diagnóstica:</span>
                    <span class="value">
                        @foreach ($nomeDiagnosticos as $diagnostico)
                            {{ $diagnostico }}@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </span>
                </div>
                <div class="field">
                    <span class="label">Detalhes Hipótese Diagnóstica:</span>
                    <span class="value">{{ $prontuario->hipotese_diagnostica_detalhes ?? 'Não informado' }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Conduta</h2>

            <div class="field" style="grid-column: 1 / -1;">
                <span class="label">Orientações:</span>
                <span class="value">{{ $prontuario->orientacoes ?? 'Não informado' }}</span>
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <span class="label">Evolução:</span>
                <span class="value">{{ $prontuario->evolucao ?? 'Não informado' }}</span>
            </div>

        </div>

        <!-- Seção de Medicamentos Prescritos -->
        <div class="section">
            <h2>Medicamentos Prescritos</h2>
            <div class="fields-grid">
                @if ($prontuario->receituario && $prontuario->receituario->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Medicamento</th>
                                <th>Quantidade</th>
                                <th>Forma de Uso</th>
                                <th>Controle Especial</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prontuario->receituario as $receita)
                                <tr>
                                    <td>{{ $receita->medicamento->nome ?? 'Não informado' }}</td>
                                    <td>{{ $receita->qtd ?? 'Não informado' }}</td>
                                    <td>{{ $receita->forma_uso ?? 'Não informado' }}</td>
                                    <td>{{ $receita->medicamento->controle_especial ? 'Sim' : 'Não' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="field full-width">
                        <span class="value">Nenhum medicamento prescrito.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Seção de Exames Solicitados -->
        <div class="section">
            <h2>Exames Solicitados</h2>
            <div class="fields-grid">
                @if ($prontuario->solicitacaoExames && $prontuario->solicitacaoExames->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Exames e Resultados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prontuario->solicitacaoExames as $solicitacao)
                                <tr>
                                    <td>{{ $solicitacao->resultado ?? 'Não há exames solicitados' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="field full-width">
                        <span class="value">Nenhum exame solicitado.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Seção de Encaminhamentos -->
        <div class="section">
            <h2>Encaminhamentos</h2>
            <div class="fields-grid">
                @if ($prontuario->encaminhamentosEspecialidades && $prontuario->encaminhamentosEspecialidades->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Especialidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prontuario->encaminhamentosEspecialidades as $encaminhamento)
                                @if ($encaminhamento->especialidades && $encaminhamento->especialidades->count() > 0)
                                    @foreach ($encaminhamento->especialidades as $especialidade)
                                        <tr>
                                            <td>{{ $especialidade->nome ?? 'Não informado' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="field full-width">
                        <span class="value">Nenhum encaminhamento registrado.</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="signature-area">
            <div style="text-align: center; font-size: 0.9rem;">
                <span>{{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('DD [de] MMMM [de] YYYY') }}</span>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <span>Dr(a). {{ $prontuario->medico->nome }}</span><br>
                    <span>CRM: {{ $prontuario->medico->crm }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
