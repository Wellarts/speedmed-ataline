<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoClinico;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    public function prontuario($id)
        {
            // dd($id);
            $prontuario = AtendimentoClinico::with([
                'receituario.medicamento',
                'solicitacaoExames.exames',
                'encaminhamentosEspecialidades.especialidades'
            ])->find($id);
            
            if (!$prontuario) {
                abort(404);
            }
    
            // Otimização das consultas para diagnósticos
            $nomeDiagnosticos = [];
            if (!empty($prontuario->hipotese_diagnostica_id) && is_array($prontuario->hipotese_diagnostica_id)) {
                $diagnosticos = \App\Models\Doenca::whereIn('id', $prontuario->hipotese_diagnostica_id)->pluck('nome', 'id')->toArray();
                foreach ($prontuario->hipotese_diagnostica_id as $diagnosticoId) {
                    $nomeDiagnosticos[] = $diagnosticos[$diagnosticoId] ?? 'Diagnóstico não encontrado';
                }
            }

        $pdf = Pdf::loadView('documentos.prontuario', compact('prontuario', 'nomeDiagnosticos'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);
        return $pdf->stream('prontuario.pdf', ['Attachment' => false]);


        
    }

    public function receituarioComum($id)
    {
        $prescricao = AtendimentoClinico::find($id);
        if (!$prescricao) {
            abort(404);
        }



        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documentos.receituario_comum', compact('prescricao'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);
        return $pdf->stream('receituario_comum.pdf', ['Attachment' => false]);
    }

    public function receituarioEspecial($id)
    {
        $prescricaoEspecial = AtendimentoClinico::find($id);
        if (!$prescricaoEspecial) {
            abort(404);
        }


        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documentos.receituario_especial', compact('prescricaoEspecial'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);
        return $pdf->stream('receituario_especial.pdf', ['Attachment' => false]);
    }
    public function printReceituario($id)
    {
        $atendimento = AtendimentoClinico::find($id);
        if (!$atendimento) {
            abort(404);
        }
        // Filtrar apenas medicamentos de controle Comum do receituário
        $medicamentoReceituarioComum = $atendimento->receituario->filter(function ($receituario) {
            return $receituario->medicamento && $receituario->medicamento->controle_especial == 0;
        });

        // Verificar se existem medicamentos de controle Comum
        if ($medicamentoReceituarioComum->isEmpty()) {
            abort(404, 'Nenhum medicamento de controle Comum encontrado neste receituário.');
        }
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documentos.receituarioNew', compact('medicamentoReceituarioComum', 'atendimento'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);
        return $pdf->stream('receituario_comum.pdf', ['Attachment' => false]);
    }

    public function printReceituarioEspecial($id)
    {
        $atendimento = AtendimentoClinico::find($id);

        if (!$atendimento) {
            abort(404);
        }

        // Filtrar apenas medicamentos de controle especial do receituário
        $medicamentoReceituarioEspecial = $atendimento->receituario->filter(function ($receituario) {
            return $receituario->medicamento && $receituario->medicamento->controle_especial == 1;
        });

        // Verificar se existem medicamentos de controle especial
        if ($medicamentoReceituarioEspecial->isEmpty()) {
            abort(404, 'Nenhum medicamento de controle especial encontrado neste receituário.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documentos.receituarioNewEspecial', compact('medicamentoReceituarioEspecial', 'atendimento'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);
        return $pdf->stream('receituario_especial.pdf', ['Attachment' => false]);
    }

    public function printSolicitacaoExames($id)
    {
        $atendimento = AtendimentoClinico::find($id);
        if (!$atendimento) {
            abort(404);
        }

        $listaExames = $atendimento->solicitacaoExames;
      if ($listaExames->isEmpty()) {
            abort(404, 'Nenhum exame solicitado neste atendimento.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documentos.solicitacaoExames', compact('atendimento', 'listaExames'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true);
        return $pdf->stream('solicitacao_exames.pdf', ['Attachment' => false]);
    }

    public function printEncaminhamentos($id)
    {
        $atendimento = AtendimentoClinico::find($id);
        if (!$atendimento) {
            abort(404);
        }

        $encaminhamentos = $atendimento->encaminhamentosEspecialidades;
        if ($encaminhamentos->isEmpty()) {
            abort(404, 'Nenhum encaminhamento encontrado neste atendimento.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('documentos.encaminhamentos', compact('atendimento', 'encaminhamentos'))
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('dpi', 150)
            ->setOption('defaultFont', 'sans-serif')
            ->setOption('enable_php', true);
        return $pdf->stream('encaminhamentos.pdf', ['Attachment' => false]);
    }
}
