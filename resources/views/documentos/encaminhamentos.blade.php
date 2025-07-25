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
            opacity: 0.5;
            /* Adjust opacity for background image */
        }

        .centered-text {
            position: absolute;

            top: 25%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #666666;
        }

        .centered-prescricao {
            position: absolute;
            margin: 0% auto;
            top: 40%;
            left: 5%;
            transform: translateY(-50%);
            font-size: 20px;
            text-align: left;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #666666;
        }

        .data {

            margin-top: 100%;
            text-align: center;
            font-size: 16px;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #666666;
        }

        .exame-item {
            font-size: 20px;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #666666;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    @if($atendimento->encaminhamento && $atendimento->encaminhamento->count() > 0)
    @foreach($atendimento->encaminhamento as $encaminhamento)
    @foreach($encaminhamento->especialidades as $especialidade)
    <div class="container" @if(!$loop->last || !$loop->parent->last) style="page-break-after: always;" @endif>
        <img src="{{ public_path('img/receituario_comum.jpg') }}" class="background-image" alt="Receituário Comum" />
        <div style="position: absolute; top: 20%; left: 50%; transform: translateY(-50%); font-size: 22px; text-align: left; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #666666;">
            Paciente: {{ $atendimento->paciente->nome }} <br>

        </div>

        <div class="centered-prescricao">
            <p><b>Encaminhamento:</b></p>
            <div class="exame-item">
                • {{ $especialidade->nome ?? '' }}
            </div>
        </div>
        <div class="data">{{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
        <div style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); text-align: center; color: #666666; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
            <div style="border-top: 1px solid #666666; padding-top: 5px; width: 250px;">
                Dr(a). {{$atendimento->medico->nome}} <br>
                CRM: {{$atendimento->medico->crm}}
            </div>
        </div>
    </div>
    @endforeach
    @endforeach
    @else
    <div class="container">
        <img src="{{ public_path('img/receituario_comum.jpg') }}" class="background-image" alt="Receituário Comum" />
        <div style="position: absolute; top: 20%; left: 50%; transform: translateY(-50%); font-size: 16px; text-align: left; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #666666;">
            Paciente: {{ $atendimento->paciente->nome }} <br>

        </div>

        <div class="centered-prescricao">
            <p><b>Encaminhamento:</b></p>
            <p>Nenhum encaminhamento solicitado.</p>
        </div>
        <div class="data">{{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}</div>
        <div style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); text-align: center; color: #666666; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
            <div style="border-top: 1px solid #666666; padding-top: 5px; width: 250px;">
                Dr(a). {{$atendimento->medico->nome}} <br>
                CRM: {{$atendimento->medico->crm}}
            </div>
        </div>
    </div>
    @endif
</body>

</html>