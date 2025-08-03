<!DOCTYPE html>
<html>
<head>
    <title>Receituário</title>
    <style>
        .container {
            position: relative;
            text-align: center;
            margin: 0% auto;
            width: 100%;    
        }
        
        .background-image {
            width: 120%;
            height: 110%;
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }
        
        .centered-text {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #313131;
        }

        .centered-prescricao {
            position: absolute;
            margin: 0% auto;
            top: 40%;
            left: 5%;
            transform: translateY(-50%);
            font-size: 16px;
            text-align: left;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #313131;
        }
        .data {
            margin-top:  100%;
            text-align: center;
            font-size: 16px;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #313131;
        }
    </style>
</head>
<body>
    @php
        // Agrupa exames por tipo
        $examesPorTipo = [];
        if($atendimento->solicitacaoExames && $atendimento->solicitacaoExames->count() > 0) {
            foreach($atendimento->solicitacaoExames as $solicitacao) {
                foreach($solicitacao->exames as $exame) {
                    $examesPorTipo[$exame->tipo][] = $exame;
                }
            }
        }
        
        // Conta quantos tipos de exames existem
        $totalTipos = count($examesPorTipo);
        $contador = 0;
    @endphp

    @if(count($examesPorTipo) > 0)
        @foreach($examesPorTipo as $tipo => $exames)
            @php $contador++; @endphp
            <div class="container" style="@if($contador < $totalTipos) page-break-after: always; @endif">
                <img src="{{ public_path('img/receituario_comum.jpg') }}" class="background-image" alt="Receituário Comum"/>
                 <div style="position: absolute; top: 20%; left: 10%; transform: translateY(-50%); font-size: 16px; text-align: left; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #313131;">
                    Paciente: {{ $atendimento->paciente->nome }} <br>
                    CPF: {{ $atendimento->paciente->cpf }} <br>
                </div>
                <div class="centered-prescricao">
                    <p><b>Exames solicitados ({{ $tipo }}):</b></p>
                    @foreach($exames as $exame)
                        <div class="exame-item">
                            • {{ $exame->nome }}
                        </div>
                    @endforeach
                </div>
                <div class="data">{{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
                <div style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); text-align: center; color: #313131; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                    <div style="border-top: 1px solid #666666; padding-top: 5px; width: 250px;">
                        Dr(a). {{$atendimento->medico->nome}} <br>
                        CRM:  {{$atendimento->medico->crm}}
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="container">
            <img src="{{ public_path('img/receituario_comum.jpg') }}" class="background-image" alt="Receituário Comum"/>
            <div style="position: absolute; top: 20%; left: 50%; transform: translateY(-50%); font-size: 16px; text-align: left; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #313131;">
                Paciente: {{ $atendimento->paciente->nome }} <br>
            </div>
            <div class="centered-prescricao">
                <p><b>Exames solicitados:</b></p>
                <p>Nenhum exame solicitado.</p>
            </div>
            <div class="data">{{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
            <div style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); text-align: center; color: #313131; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                <div style="border-top: 1px solid #666666; padding-top: 5px; width: 250px;">
                    Dr(a). {{$atendimento->medico->nome}} <br>
                    CRM:  {{$atendimento->medico->crm}}
                </div>
            </div>
        </div>
    @endif
</body>
</html>