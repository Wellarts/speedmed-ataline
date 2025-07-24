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
        }

        /* General box styling */
        .header, .patient-info, .prescription, .pharmacy-info, .signature-area > div, .footer {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

        .patient-info, .pharmacy-info {
            flex: 1;
            min-width: 45%;
            padding: 10px;
        }

        .patient-info h3, .prescription h3, .pharmacy-info h3 {
            margin: 0 0 6px 0;
            font-size: 12px;
            color: #49494a;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 3px;
        }
        .patient-info p, .prescription p, .pharmacy-info p {
            margin: 3px 0;
            font-size: 13px;
            color: #495057;
        }

        .prescription {
            margin-bottom: 8px;
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
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        .signature-area {
            margin-top: 50px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 8px;
        }
        .signature-area > div {
            flex: 1;
            padding: 10px;
            box-sizing: border-box;
        }
        .signature-area p {
            margin: 2px 0;
            font-size: 13px;
            color: #495057;
        }

        .footer {
            margin-top: 170px;
            font-size: 10px;
            padding: 0px;
        }
        .footer p {
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
    <!-- Primeira Via -->
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
                        <p>Nome da Clínica/Hospital</p>
                        <p>Endereço Completo</p>
                        <p>Telefone: (XX) XXXX-XXXX</p>
                        <p>CNPJ: XX.XXX.XXX/XXXX-XX</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-sections-container">
        <div class="patient-info">
            <h3>Identificação do Paciente</h3>
            <p><strong>Nome:</strong> {{ $atendimento->paciente->nome ?? '-' }} </p>
            <p><strong>Endereço:</strong> {{ $atendimento->paciente->endereco_completo ?? 'Não informado'.' - '.$atendimento->paciente->cidade->nome ?? 'Não informado'.' - ' .$atendimento->paciente->estado->uf ?? 'Não informado'  }}</p>
            <p><strong>RG:</strong> {{ $atendimento->paciente->rg }} <strong style="margin-left: 40%">CPF:</strong> {{ $atendimento->paciente->cpf }}</p>
            <p><strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($atendimento->paciente->data_nascimento ?? 'Não informado')) }}<strong style="margin-left: 24%">Telefone:</strong> {{ $prescricaoEspecial->paciente->telefone ?? 'Não informado' }}</p>
        </div>
    </div>    

    <div class="prescription">
        <h3>Prescrição</h3>
        
            @foreach($medicamentoReceituarioEspecial as $medicamento)
                <table style="width: 100%; font-size: 9pt">
                    <tr>                        
                        <td style="text-align: left; width: 30%;"><b>{{ $medicamento->medicamento->nome }}</b></td>
                        <td style="text-align: center; width: 40%;">________________________________________________________</td>
                        <td style="text-align: left; width: 30%;"><b>{{ $medicamento->qtd }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: left;">{{ $medicamento->forma_uso }}</td>
                    </tr>
                </table>
                
            @endforeach
        
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="pharmacy-info">
                    <h3>Identificação da Farmácia</h3>
                    <p>Nome da Farmácia:__________________________</p>
                    <p>CNPJ: ____________________________________ </p>
                    <p>Farmacêutico Responsável: ___________________ </p>
                    <p>CRF: _____________________________________ </p>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="pharmacy-info">
                    <h3>Comprador</h3>
                    <p>Nome: _________________________________</p>
                    <p>RG: _________________ Emissor: __________</p>
                    <p>End: __________________________________</p>
                    <p>Cidade: ________________________ UF: ____</p>
                    <p>Telefone:(_)____________________________</p>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="signature-area"> 
                    <p>_______________________________</p>
                    <p>Dr(a). {{$atendimento->medico->nome}}</p>
                    <p>CRM: {{$atendimento->medico->crm}}</p>
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
    </table>

    <div class="footer">
        <p>Data da Prescrição: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p>Este receituário é válido por 30 (trinta) dias a partir da data da prescrição</p>
        <p>1ª via: Farmácia | 2ª via: Paciente</p>
    </div>

    <!-- Quebra de página -->
    <div class="page-break"></div>

    <!-- Segunda Via -->
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
                        <p>Nome da Clínica/Hospital</p>
                        <p>Endereço Completo</p>
                        <p>Telefone: (XX) XXXX-XXXX</p>
                        <p>CNPJ: XX.XXX.XXX/XXXX-XX</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-sections-container">
        <div class="patient-info">
            <h3>Identificação do Paciente</h3>
            <p><strong>Nome:</strong> {{ $atendimento->paciente->nome ?? '-' }} </p>
            <p><strong>Endereço:</strong> {{ $atendimento->paciente->endereco_completo ?? 'Não informado'.' - '.$atendimento->paciente->cidade->nome ?? 'Não informado'.' - ' .$atendimento->paciente->estado->nome ?? 'Não informado'.' - '.$atendimento->paciente->estado->uf ?? 'Não informado'  }}</p>
            <p><strong>RG:</strong> {{ $atendimento->paciente->rg }} <strong style="margin-left: 40%">CPF:</strong> {{ $atendimento->paciente->cpf }}</p>
            <p><strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($atendimento->paciente->data_nascimento ?? 'Não informado')) }}<strong style="margin-left: 24%">Telefone:</strong> {{ $prescricaoEspecial->paciente->telefone ?? 'Não informado' }}</p>
        </div>
    </div>    

    <div class="prescription">
        <h3>Prescrição</h3>
        
            @foreach($medicamentoReceituarioEspecial as $medicamento)
                <table style="width: 100%; font-size: 9pt">
                    <tr>                        
                        <td style="text-align: left; width: 30%;"><b>{{ $medicamento->medicamento->nome }}</b></td>
                        <td style="text-align: center; width: 40%;">________________________________________________________</td>
                        <td style="text-align: left; width: 30%;"><b>{{ $medicamento->qtd }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: left;">{{ $medicamento->forma_uso }}</td>
                    </tr>
                </table>
                
            @endforeach
        
    </div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="pharmacy-info">
                    <h3>Identificação da Farmácia</h3>
                    <p>Nome da Farmácia:__________________________</p>
                    <p>CNPJ: ____________________________________ </p>
                    <p>Farmacêutico Responsável: ___________________ </p>
                    <p>CRF: _____________________________________ </p>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="pharmacy-info">
                    <h3>Comprador</h3>
                    <p>Nome: _________________________________</p>
                    <p>RG: _________________ Emissor: __________</p>
                    <p>End: __________________________________</p>
                    <p>Cidade: ________________________ UF: ____</p>
                    <p>Telefone:(_)____________________________</p>
                </div>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="signature-area"> 
                    <p>_______________________________</p>
                    <p>Dr(a). {{$atendimento->medico->nome}}</p>
                    <p>CRM: {{$atendimento->medico->crm}}</p>
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
    </table>

    <div class="footer">
        <p>Data da Prescrição: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p>Este receituário é válido por 30 (trinta) dias a partir da data da prescrição</p>
        <p>1ª via: Farmácia | 2ª via: Paciente</p>
    </div>
</body>
</html>