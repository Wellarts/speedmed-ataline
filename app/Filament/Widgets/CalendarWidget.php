<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions\CreateAction;
use Saade\FilamentFullCalendar\Actions\EditAction;
use Saade\FilamentFullCalendar\Actions\DeleteAction;
use App\Filament\Resources\EventResource;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\AgendamentoResource;
use Filament\Forms; // Add this import for Forms components
use App\Models\Agendamento;
use Filament\Forms\Form;


class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Agendamento::class;

    public function fetchEvents(array $fetchInfo): array
    {

        return Agendamento::query()
            ->where('data_hora_inicio', '>=', $fetchInfo['start'])
            ->where('data_hora_fim', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn(Agendamento $event) => [
                    'id' => $event->id,
                    'title' => $event->paciente,
                    'start' => $event->data_hora_inicio,
                    'end' => $event->data_hora_fim,
                    // 'url' => AgendamentoResource::getUrl('view', ['record' => $event]),
                    // 'shouldOpenUrlInNewTab' => true
                ]
            )
            ->toArray();
    }



    public function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(12)
                ->schema([
                    Forms\Components\TextInput::make('paciente')
                        ->label('Paciente')
                        ->columnSpan(6),
                    Forms\Components\TextInput::make('contato')
                        ->label('Contato')
                        ->mask('(99) 99999-9999')
                        ->columnSpan(6),
                    Forms\Components\DateTimePicker::make('data_hora_inicio')
                        ->label('Início')
                        ->seconds(false)
                        ->columnSpan(6),
                    Forms\Components\DateTimePicker::make('data_hora_fim')
                        ->label('Fim')
                        ->seconds(false)
                        ->columnSpan(6),
                    Forms\Components\Select::make('medico_id')
                        ->label('Médico')
                        ->relationship('medico', 'name')
                        ->default(
                            fn($query) => $query->where('name', 'Ataline Barbosa')->first()?->id
                        )
                        ->required()
                        ->columnSpan(6),
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'agendado' => 'Agendado',
                            'confirmado' => 'Confirmado',
                            'cancelado' => 'Cancelado',
                        ])
                        ->default(fn($state) => $state ?? 'agendado')
                        ->columnSpan(6),
                    Forms\Components\Textarea::make('observacoes')
                        ->label('Observações')
                        ->autosize()
                        ->columnSpan(12),
                ]),
        ];
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'data_hora_inicio' => $arguments['start'] ?? null,
                            'data_hora_fim' => $arguments['end'] ?? null
                        ]);
                    }
                )
                ->label('Novo Agendamento')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make()
                ->mountUsing(
                    function (Agendamento $record, Form $form, array $arguments) {
                        $form->fill([
                            'paciente' => $record->paciente,
                            'data_hora_inicio' => $arguments['event']['start'] ?? $record->data_hora_inicio,
                            'data_hora_fim' => $arguments['event']['end'] ?? $record->data_hora_fim,
                            'medico_id' => $record->medico_id,
                            'contato' => $record->contato,
                            'status' => $record->status,
                            'observacoes' => $record->observacoes,
                        ]);
                    }
                ),

        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
            el.setAttribute("x-tooltip", "tooltip");
            el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
        }
    JS;
    }
}
