<?php

namespace App\Http\Controllers;

use App\Models\AtendimentoClinico;
use Barryvdh\DomPDF\PDF;

use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    public function prontuario($id)
    {
        // dd($id);
        $prontuario = AtendimentoClinico::find($id);
        if (!$prontuario) {
            abort(404);
        }

        $nomeDiagnosticos = [];
        foreach ($prontuario->hipotese_diagnostica_id as $diagnosticoId) {
            $diagnostico = \App\Models\Doenca::find($diagnosticoId);
            if ($diagnostico) {
                $nomeDiagnosticos[] = $diagnostico->nome;
            } else {
                $nomeDiagnosticos[] = 'Diagnóstico não encontrado';
            }
        }

        $nomePrescricoes = [];
        foreach ($prontuario->medicamentos_id as $medicamentoId) {
            $medicamento = \App\Models\Medicamento::find($medicamentoId);
            if ($medicamento) {
                $nomePrescricoes[] = $medicamento->nome;
            } else {
                $nomePrescricoes[] = 'Medicamento não encontrado';
            }
        }

        $nomeExames = [];
        foreach ($prontuario->exames_id as $exameId) {
            $exame = \App\Models\Exame::find($exameId);
            if ($exame) {
                $nomeExames[] = $exame->nome;
            } else {
                $nomeExames[] = 'Exame não encontrado';
            }
        }

        $nomeEncaminhamentos = [];
        foreach ($prontuario->encaminhamentos_id as $encaminhamentoId) {
            $encaminhamento = \App\Models\Especialidade::find($encaminhamentoId);
            if ($encaminhamento) {
                $nomeEncaminhamentos[] = $encaminhamento->nome;
            } else {
                $nomeEncaminhamentos[] = 'Encaminhamento não encontrado';
            }
        }







        return view('documentos.prontuario', compact('prontuario', 'nomeDiagnosticos', 'nomePrescricoes', 'nomeExames', 'nomeEncaminhamentos'));
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
}
