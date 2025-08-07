<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receituário de Controle Especial</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            margin: 0px;
            padding: 5mm;
            max-width: 210mm;
            background-color: #f8f9fa;
            line-height: 1.3;
            box-sizing: border-box;
            position: relative; /* Added for absolute positioning context */
            min-height: 297mm; /* A4 height for context */
        }

        /* General box styling */
        .header,
        .patient-info,
        .prescription,
        .pharmacy-info,
        .signature-area>div,
        .footer-content { /* Changed from .footer to .footer-content */
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 8px;
        }

        .header {
            text-align: center;
            border-bottom: none;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0 0 3px 0;
            color: #2c3e50;
            font-weight: 700;
            font-size: 20px;
        }

        .clinic-info p {
            margin: 1px 0;
            font-size: 13px;
            color: #495057;
        }

        .info-sections-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
        }

        .patient-info,
        .pharmacy-info {
            flex: 1;
            min-width: 45%;
            padding: 10px;
            box-sizing: border-box;
        }

        .patient-info h3,
        .prescription h3,
        .pharmacy-info h3 {
            margin: 0 0 6px 0;
            font-size: 12px;
            color: #49494a;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 3px;
        }

        .patient-info p,
        .prescription p,
        .pharmacy-info p {
            margin: 3px 0;
            font-size: 13px;
            color: #495057;
        }

        .prescription {
            margin-bottom: 8px;
            /* Allow prescription to grow */
        }

        textarea {
            width: calc(100% - 12px);
            height: 70px;
            margin: 6px 0;
            padding: 6px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
            font-family: inherit;
            font-size: 13px;
        }

        textarea:focus {
            outline: none;
            border-color: #4d4d4e;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .signature-area {
            text-align: center;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 20px; /* Adjusted margin-top for spacing */
        }

        .signature-area>div {
            flex: 1;
            padding: 10px;
            box-sizing: border-box;
        }

        .signature-area p {
            margin: 2px 0;
            font-size: 13px;
            color: #495057;
        }

        .bottom-fixed-container {
            position: absolute;
            bottom: 5mm; /* Adjust as needed for padding from the bottom of the page */
            left: 5mm;
            right: 5mm;
            width: calc(100% - 10mm);
            box-sizing: border-box;
        }

        .footer-content { /* Renamed class for clarity */
            font-size: 10px;
            padding: 0px;
            margin-top: 10px; /* Spacing between signature and footer */
        }

        .footer-content p {
            margin: 1px 0;
            color: #6c757d;
        }

        .page-break {
            page-break-after: always;
        }

        .via-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="via-indicator">1ª VIA - FARMÁCIA</div>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 100px;">
                </td>
                <td style="width: 70%; text-align: right">
                    <h4>RECEITUÁRIO DE CONTROLE ESPECIAL</h4>
                    <div class="clinic-info">
                        <p>Clínica Unimaia</p>
                        <p>Rua Major Capitú, 75 - Centro<br>
                             Lajedo - PE  CEP: 55385000</p>
                        <p>Telefone: (81) 9.8200-7298</p>
                        
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-sections-container">
        <div class="patient-info">
            <h3>Identificação do Paciente</h3>
            <p><strong>Nome:</strong> {{ $atendimento->paciente->nome ?? '-' }} </p>
            <p><strong>Endereço:</strong>
                {{ $atendimento->paciente->endereco_completo ?? ('Não informado' . ' - ' . $atendimento->paciente->cidade->nome ?? ('Não informado' . ' - ' . $atendimento->paciente->estado->uf ?? 'Não informado')) }}
            </p>
            <p><strong>RG:</strong> {{ $atendimento->paciente->rg }} <strong style="margin-left: 40%">CPF:</strong>
                {{ $atendimento->paciente->cpf }}</p>
            <p><strong>Data de Nascimento:</strong>
                {{ date('d/m/Y', strtotime($atendimento->paciente->data_nascimento ?? 'Não informado')) }}<strong
                    style="margin-left: 24%">Telefone:</strong>
                {{ $prescricaoEspecial->paciente->telefone ?? 'Não informado' }}</p>
        </div>
    </div>

    <div class="prescription">
        <h3>Prescrição</h3>

        @foreach ($medicamentoReceituarioEspecial as $medicamento)
            <table style="width: 100%; font-size: 9pt">
                <tr>
                    <td style="text-align: left; width: 30%;"><b>{{ $medicamento->medicamento->nome }} {{ $medicamento->dosagem }}</b></td>
                    <td style="text-align: center; width: 40%;">______________________________________________________
                    </td>
                    <td style="text-align: left; width: 30%;"><b>{{ $medicamento->qtd }}</b></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left;">{{ $medicamento->forma_uso }}</td>
                </tr>
            </table>
        @endforeach
    </div>

    <div class="bottom-fixed-container">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="pharmacy-info" style="height: 140px; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3>Identificação da Farmácia</h3>
                        <p>Nome da Farmácia:__________________________</p>
                        <p>CNPJ: ____________________________________ </p>
                        <p>Farmacêutico Responsável: ___________________ </p>
                        <p>CRF: _____________________________________ </p>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="pharmacy-info" style="height: 140px; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3>Comprador</h3>
                        <p>Nome: _________________________________</p>
                        <p>RG: _________________ Emissor: __________</p>
                        <p>End: __________________________________</p>
                        <p>Cidade: ________________________ UF: ____</p>
                        <p>Telefone:(_)____________________________</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="signature-area" style="margin-bottom: 0;">
                        <p>_______________________________</p>
                        <p>Dr(a). {{ $atendimento->medico->nome }}</p>
                        <p>CRM: {{ $atendimento->medico->crm }}</p>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="signature-area" style="margin-bottom: 0;">
                        <p>_______________________________</p>
                        <p>Assinatura do Farmacêutico</p>
                        <p>CRF: __________ UF: ____</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 0;">
                    <div class="footer-content"> <p>Data da Prescrição: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                        <p>Este receituário é válido por 30 (trinta) dias a partir da data da prescrição</p>
                        <p>1ª via: Farmácia | 2ª via: Paciente</p>
                    </div>

                </td>
            </tr>
        </table>
    </div>


    <div class="page-break"></div>

    <div class="via-indicator">2ª VIA - PACIENTE</div>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="width: 30%;">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 100px;">
                </td>
                <td style="width: 70%; text-align: right">
                    <h4>RECEITUÁRIO DE CONTROLE ESPECIAL</h4>
                    <div class="clinic-info">
                       <p>Clínica Unimaia</p>
                        <p>Rua Major Capitú, 75 - Centro<br>
                             Lajedo - PE  CEP: 55385000</p>
                        <p>Telefone: (81) 9.8200-7298</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-sections-container">
        <div class="patient-info">
            <h3>Identificação do Paciente</h3>
            <p><strong>Nome:</strong> {{ $atendimento->paciente->nome ?? '-' }} </p>
            <p><strong>Endereço:</strong>
                {{ $atendimento->paciente->endereco_completo ?? ('Não informado' . ' - ' . $atendimento->paciente->cidade->nome ?? ('Não informado' . ' - ' . $atendimento->paciente->estado->nome ?? ('Não informado' . ' - ' . $atendimento->paciente->estado->uf ?? 'Não informado'))) }}
            </p>
            <p><strong>RG:</strong> {{ $atendimento->paciente->rg }} <strong style="margin-left: 40%">CPF:</strong>
                {{ $atendimento->paciente->cpf }}</p>
            <p><strong>Data de Nascimento:</strong>
                {{ date('d/m/Y', strtotime($atendimento->paciente->data_nascimento ?? 'Não informado')) }}<strong
                    style="margin-left: 24%">Telefone:</strong>
                {{ $prescricaoEspecial->paciente->telefone ?? 'Não informado' }}</p>
        </div>
    </div>

    <div class="prescription">
        <h3>Prescrição</h3>

        @foreach ($medicamentoReceituarioEspecial as $medicamento)
            <table style="width: 100%; font-size: 9pt">
                <tr>
                    <td style="text-align: left; width: 30%;"><b>{{ $medicamento->medicamento->nome }}</b></td>
                    <td style="text-align: center; width: 40%;">________________________________________________________
                    </td>
                    <td style="text-align: left; width: 30%;"><b>{{ $medicamento->qtd }}</b></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: left;">{{ $medicamento->forma_uso }}</td>
                </tr>
            </table>
        @endforeach
    </div>

    <div class="bottom-fixed-container">
        <table style="width: 100%;">
             <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="pharmacy-info" style="height: 140px; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3>Identificação da Farmácia</h3>
                        <p>Nome da Farmácia:__________________________</p>
                        <p>CNPJ: ____________________________________ </p>
                        <p>Farmacêutico Responsável: ___________________ </p>
                        <p>CRF: _____________________________________ </p>
                    </div>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <div class="pharmacy-info" style="height: 140px; display: flex; flex-direction: column; justify-content: space-between;">
                        <h3>Comprador</h3>
                        <p>Nome: _________________________________</p>
                        <p>RG: _________________ Emissor: __________</p>
                        <p>End: __________________________________</p>
                        <p>Cidade: ________________________ UF: ____</p>
                        <p>Telefone:(_)____________________________</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="width: 50%;">
                    <div class="signature-area">
                        <p>_______________________________</p>
                        <p>Dr(a). {{ $atendimento->medico->nome }}</p>
                        <p>CRM: {{ $atendimento->medico->crm }}</p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="signature-area">
                        <p>_______________________________</p>
                        <p>Assinatura do Farmacêutico</p>
                        <p>CRF: __________ UF: ____</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="footer-content"> <p>Data da Prescrição: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                        <p>Este receituário é válido por 30 (trinta) dias a partir da data da prescrição</p>
                        <p>1ª via: Farmácia | 2ª via: Paciente</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>