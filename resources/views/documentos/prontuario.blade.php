<!DOCTYPE html>
<html>
<head>
    <title>Prontuário Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 10px;
            background: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .section {
            margin-bottom: 25px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .fields-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }
        .field {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #333;
            min-width: 150px;
        }
        .value {
            color: #666;
        }
        @media (max-width: 900px) {
            .fields-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="float: left; height: 100px; margin-right: 33px;">
            <h1 style="text-align: right; color: #666">Prontuário Médico</h1>
            <h3 style="text-align: right; color: #666">Paciente: {{ $prontuario->paciente->nome }}</h3>
                    <p style="text-align: right; margin: 10px 0; color: #555; font-style: italic;">Status da Consulta: 
                        @switch($prontuario->status)
                            @case(1)
                                <span style="color: #2196F3;"><b>Iniciada</b></span>
                                @break
                            @case(2)
                                <span style="color: #4CAF50;"><b>Finalizada</b></span>
                                @break
                            @default
                                <span style="color: #F44336;"><b>Cancelada</b></span>
                        @endswitch <br>
                        Data/Hora Atendimento: {{ \Carbon\Carbon::parse($prontuario->data_hora_atendimento)->format('d/m/Y H:i:s') }}
                    </p>
        </div>

        <div class="section">
            <h2>Informações do Paciente</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(3, 1fr);">
                <div class="field">
                    <span class="label">Nome:</span>
                    <span class="value">{{ $prontuario->paciente->nome }}</span>
                </div>
                <div class="field">
                    <span class="label">Data de Nascimento:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($prontuario->paciente->data_nascimento)->format('d/m/Y') }}</span>
                </div>
                <div class="field">
                    <span class="label">CPF:</span>
                    <span class="value">{{ $prontuario->paciente->cpf }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Avaliação Médica</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(2, 1fr);">
            <div class="field">
                <span class="label">Queixa Principal:</span>
                <span class="value">{{ $prontuario->qp }}</span>
            </div>
            <div class="field">
                <span class="label">História da Doença Atual:</span>
                <span class="value">{{ $prontuario->hdp }}</span>
            </div>
            <div class="field">
                <span class="label">Doenças Preexistentes:</span>
                <span class="value">
                @if($prontuario->doenca && $prontuario->doenca->count())
                    {{ $prontuario->doenca->pluck('nome')->implode(', ') }}
                @else
                    Nenhuma
                @endif
                </span>
            </div>
            <div class="field">
                <span class="label">Data de Início dos Sintomas:</span>
                <span class="value">{{ $prontuario->data_inicio_sintomas }}</span>
            </div>
            <div class="field">
                <span class="label">Cirurgias/Hospitalizações:</span>
                <span class="value">{{ $prontuario->cirurgias_hospitalizacoes }}</span>
            </div>
            <div class="field">
                <span class="label">Outras Alergias:</span>
                <span class="value">{{ $prontuario->outros_alergias }}</span>
            </div>
            <div class="field">
                <span class="label">Medicamentos em Uso Contínuo:</span>
                <span class="value"> @if($prontuario->medicamentoUso && $prontuario->medicamentoUso->count())
                    {{ $prontuario->medicamentoUso->pluck('nome')->implode(', ') }}
                @else
                    Nenhuma
                @endif</span>
            </div>
            <div class="field">
                <span class="label">Detalhes dos Medicamentos em Uso:</span>
                <span class="value">{{ $prontuario->medicamento_uso_detalhes }}</span>
            </div>
            
            
            
            <div class="field">
                <span class="label">Doenças Familiares:</span>
                <span class="value">@if($prontuario->doencaFamiliar && $prontuario->doencaFamiliar->count())
                    {{ $prontuario->doencaFamiliar->pluck('nome')->implode(', ') }}
                @else
                    Nenhuma
                @endif</span>
            </div>
            <div class="field">
                <span class="label">Parentesco das Doenças Familiares:</span>
                <span class="value">{{ $prontuario->doenca_familiar_parentesco }}</span>
            </div>
            </div>
        </div>
        <div class="field">
                <span class="label">Alergia Medicamentosa:</span>
                <span class="value">
                @if($prontuario->medicamentoAlergias && $prontuario->medicamentoAlergias->count())
                    {{ $prontuario->medicamentoAlergias->pluck('nome')->implode(', ') }}
                @else
                    Nenhuma
                @endif
                </span>
            </div>

        <div class="section">
            <h2>Estilo de Vida</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(6, 1fr);">
            <div class="field">
                <span class="label">DUM:</span>
                <span class="value">{{ \Carbon\Carbon::parse($prontuario->dum)->format('d/m/Y') }}</span>
            </div>
            <div class="field">
                <span class="label">Tabagismo:</span>
                <span class="value">{{ $prontuario->tabagismo == 1 ? 'Sim' : ($prontuario->tabagismo === 0 ? 'Não' : $prontuario->tabagismo) }}</span>
            </div>
            <div class="field">
                <span class="label">Alcoolismo:</span>
                <span class="value">{{ $prontuario->alcoolismo == 1 ? 'Sim' : ($prontuario->alcoolismo === 0 ? 'Não' : $prontuario->alcoolismo) }}</span>
            </div>
            <div class="field">
                <span class="label">Drogas:</span>
                <span class="value">{{ $prontuario->drogas == 1 ? 'Sim' : ($prontuario->drogas === 0 ? 'Não' : $prontuario->drogas) }}</span>
            </div>
            <div class="field">
                <span class="label">Atividade Física:</span>
                <span class="value">{{ $prontuario->atividade_fisica == 1 ? 'Sim' : ($prontuario->atividade_fisica === 0 ? 'Não' : $prontuario->atividade_fisica) }}</span>
            </div>
            <div class="field">
                <span class="label">Dieta:</span>
                <span class="value">{{ $prontuario->dieta == 1 ? 'Sim' : ($prontuario->dieta === 0 ? 'Não' : $prontuario->dieta) }}</span>
            </div>
            </div>
        </div>
                <div class="field">
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
            </div>
        </div>

        <div class="section">
            <h2>Exame Físico</h2>
            <div class="fields-grid">
                <div class="field">
                    <span class="label">Observações Exame Físico:</span>
                    <span class="value">{{ $prontuario->obs_exame_fisico }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Hipótese Diagnóstica</h2>
            <div class="fields-grid">
                <div class="field">
                    <span class="label">Hipótese Diagnóstica:</span>
                    <span class="value">
                         @foreach($nomeDiagnosticos as $diagnostico)
                            {{$diagnostico}}@if(!$loop->last), @endif   
                        @endforeach
                
                        </span>
                    </span>
                </div>
                <div class="field">
                    <span class="label">Detalhes Hipótese Diagnóstica:</span>
                    <span class="value">{{ $prontuario->hipotese_diagnostica_detalhes }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Conduta</h2>
            <div class="fields-grid" style="grid-template-columns: repeat(2, 1fr);">
            <div class="field">
                <span class="label">Medicamentos:</span>
                <span class="value">
                @foreach($nomePrescricoes as $prescricao)
                    {{$prescricao}}@if(!$loop->last),@endif
                @endforeach
                </span>
            </div>
            <div class="field">
                <span class="label">Detalhes Medicamentos:</span>
                <span class="value">{{ $prontuario->medicamentos_detalhes }}</span>
            </div>
            <div class="field">
                <span class="label">Exames Solicitados:</span>
                <span class="value">
                    @foreach($nomeExames as $exame)
                        {{$exame}}@if(!$loop->last),@endif
                    @endforeach</span>
                
            </div>
            <div class="field">
                <span class="label">Resultados dos Exames:</span>
                <span class="value">{{ $prontuario->resultados_exames }}</span>
            </div>
            <div class="field">
                <span class="label">Encaminhamentos:</span>
                <span class="value">@foreach($nomeEncaminhamentos as $encaminhamento)
                        {{$encaminhamento}}@if(!$loop->last),@endif                       
                    @endforeach</span>
                
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <span class="label">Orientações:</span>
                <span class="value">{{ $prontuario->orientacoes }}</span>
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <span class="label">Evolução:</span>
                <span class="value">{{ $prontuario->evolucao }}</span>
            </div>         
           
        </div>
    </div>
    <div class="section" style="margin-top: 50px;">
                    <div style="margin-top: 20px; text-align: right;">
                        <span>Data: {{ \Carbon\Carbon::now()->locale('pt_BR')->formatLocalized('%d de %B de %Y') }}</span>
                    </div>
                    <br><br>
                <div style="text-align: center;">
                    <div style="border-top: 1px solid #000; width: 250px; margin: 0 auto; padding-top: 10px;">
                        <span>Dr(a). {{ $prontuario->medico->nome }}</span><br>
                        <span>CRM: {{ $prontuario->medico->crm }}</span>
                       
                    </div>
                    
                </div>
            </div>
    
</body>
</html>
