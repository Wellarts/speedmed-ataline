<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receituário de Controle Especial</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            margin: 0px; /* Reset margin */
            padding: 10mm; /* Use mm for print-like consistency, or adjust as needed */
            max-width: 210mm; /* A4 width */
            /* height: 297mm;  Usually not set for scrollable web content, better for print media queries */
            background-color: #f8f9fa;
            line-height: 1.3; /* Slightly reduced line height for compactness */
            box-sizing: border-box; /* Include padding in the width */
        }

        /* General box styling */
        .header, .patient-info, .prescription, .pharmacy-info, .signature-area > div, .footer {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px; /* Consistent padding for main sections */
            margin-bottom: 10px; /* Reduced margin between sections */
        }

        .header {
            text-align: center;
            border-bottom: none; /* Removed border-bottom as box-shadow makes it clean */
            padding-bottom: 15px; /* Adjust padding as border is gone */
        }
        .header h2 {
            margin: 0 0 5px 0; /* Reduced margin */
            color: #2c3e50;
            font-weight: 700; /* Slightly bolder */
            font-size: 20px; /* Slightly larger for main title */
        }
        .clinic-info p {
            margin: 1px 0; /* Minimized margin for clinic info */
            font-size: 13px; /* Slightly smaller font */
            color: #495057;
        }

        /* Flex container for patient and pharmacy info */
        .info-sections-container {
            display: flex;
            justify-content: space-between;
            gap: 15px; /* Space between the two columns */
            margin-bottom: 10px; /* Space below this container */
        }

        .patient-info, .pharmacy-info {
            flex: 1; /* Allow both to grow and shrink equally */
            min-width: 45%; /* Ensure they don't get too small on smaller screens */
            padding: 15px; /* Consistent padding */
        }

        .patient-info h3, .prescription h3, .pharmacy-info h3 {
            margin: 0 0 8px 0; /* Reduced margin */
            font-size: 15px; /* Slightly smaller heading */
            color: #49494a;
            border-bottom: 1px solid #e9ecef; /* Thinner border */
            padding-bottom: 4px; /* Reduced padding */
        }
        .patient-info p, .prescription p, .pharmacy-info p {
            margin: 4px 0; /* Reduced paragraph margin */
            font-size: 13px; /* Consistent font size */
            color: #495057;
        }

        .prescription {
            margin-bottom: 10px; /* Reduced margin */
        }

        textarea {
            width: calc(100% - 16px); /* Adjusted width to account for padding */
            height: 70px; /* Slightly increased height for content */
            margin: 8px 0;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
            font-family: inherit;
            font-size: 13px; /* Consistent font size */
        }
        textarea:focus {
            outline: none;
            border-color: #4d4d4e;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        .signature-area {
            margin-top: 15px; /* Reduced top margin */
            text-align: center;
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Reduced gap between signatures */
            margin-bottom: 10px; /* Space below signatures */
        }
        .signature-area > div {
            flex: 1; /* Make them distribute space equally, replacing fixed width */
            padding: 15px; /* Consistent padding */
            box-sizing: border-box; /* Ensures padding/border are within flex allocation */
        }
        .signature-area p {
            margin: 2px 0; /* Reduced margin */
            font-size: 13px; /* Consistent font size */
            color: #495057;
        }

        .footer {
            margin-top: 10px; /* Reduced top margin */
            font-size: 10px; /* Smaller font for footer */
            padding: 8px; /* Reduced padding */
        }
        .footer p {
            margin: 1px 0; /* Minimized margin for footer info */
            color: #6c757d;
        }
    </style>
</head>
<body>
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
            <p><strong>Nome:</strong> {{ $prescricaoEspecial->paciente->nome ?? '-' }} </p>
            <p><strong>Endereço:</strong> {{ $prescricaoEspecial->paciente->endereco_completo ?? 'Não informado'.' - '.$prescricaoEspecial->paciente->cidade->nome ?? 'Não informado'.' - ' .$prescricaoEspecial->paciente->estado->nome ?? 'Não informado'.' - '.$prescricaoEspecial->paciente->estado->uf ?? 'Não informado'  }}</p>
            <p><strong>RG:</strong> {{ $prescricaoEspecial->paciente->rg }} <strong style="margin-left: 40%">CPF:</strong> {{ $prescricaoEspecial->paciente->cpf }}</p>
            <p><strong>Data de Nascimento:</strong> {{ date('d/m/Y', strtotime($prescricaoEspecial->paciente->data_nascimento ?? 'Não informado')) }}<strong style="margin-left: 24%">Telefone:</strong> {{ $prescricaoEspecial->paciente->telefone ?? 'Não informado' }}</p>
        </div>
    </div>    

    <div class="prescription">
        <h3>Prescrição</h3>
        <textarea rows="4" placeholder="Observações e orientações ao paciente, dosagem, frequência, via de administração.">
            {!! nl2br(implode("\n", array_map(function($item, $index) { return ($index + 1) . '. ' . trim($item); }, explode(",", $prescricaoEspecial->medicamentos_detalhes_especial), range(0, substr_count($prescricaoEspecial->medicamentos_detalhes_especial, ','))))) !!}
        </textarea>
    </div>
    <div class="info-sections-container">
        <div class="pharmacy-info">
            <h3>Identificação da Farmácia</h3>
            <p>Nome da Farmácia: ____________________________________</p>
            <p>CNPJ: ______________________________________________</p>
            <p>Farmacêutico Responsável: ____________________________</p>
            <p>CRF: ______________________________________________</p>
        </div>
    </div>

    

    <div class="signature-area">
        <div> 
            <p>_______________________________</p>
            <p>Assinatura e Carimbo do Médico</p>
            <p>CRM: __________ UF: ____</p>
        </div>
        <div> 
            <p>_______________________________</p>
            <p>Assinatura do Farmacêutico</p>
            <p>CRF: __________ UF: ____</p>
        </div>
    </div>

    <div class="footer">
        <p>Data da Prescrição: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p>Este receituário é válido por 30 (trinta) dias a partir da data da prescrição</p>
        <p>1ª via: Farmácia | 2ª via: Paciente</p>
    </div>
</body>
</html>