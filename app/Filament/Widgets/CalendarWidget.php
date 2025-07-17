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
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Forms\Set;

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
            Forms\Components\Grid::make([
                    'default' => 12,
                    'sm' => 12,
                    'md' => 12,
                    'lg' => 12,
                    'xl' => 12,
                ])
                ->schema([
                    Forms\Components\TextInput::make('paciente')
                        ->label('Paciente')
                        ->columnSpan([
                            'default' => 12,
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 6,
                            'xl' => 6,
                        ]),
                    Forms\Components\TextInput::make('contato')
                        ->label('Contato')
                        ->mask('(99) 99999-9999')
                        ->columnSpan([
                            'default' => 12,
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 6,
                            'xl' => 6,
                        ]),
                    Forms\Components\DateTimePicker::make('data_hora_inicio')
                        ->label('Início')
                        ->seconds(false)
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            function (Set $set, $state) {
                                if ($state) {
                                    $set('data_hora_fim', Carbon::parse($state)->addMinutes(30)->format('Y-m-d H:i'));
                                }
                            }
                        )
                        ->columnSpan([
                            'default' => 12,
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 6,
                            'xl' => 6,
                        ]),
                    Forms\Components\DateTimePicker::make('data_hora_fim')
                        ->label('Fim')
                        ->seconds(false)
                         ->displayFormat('d/m/Y H:i')
                        ->columnSpan([
                            'default' => 12,
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 6,
                            'xl' => 6,
                        ]),
                    Forms\Components\Select::make('medico_id')
                        ->label('Médico')
                        ->relationship('medico', 'name')
                        ->default(
                            fn($query) => $query->where('name', 'Ataline Barbosa')->first()?->id
                        )
                        ->required()
                        ->columnSpan([
                            'default' => 12,
                            'sm' => 12,
                            'md' => 6,
                            'lg' => 6,
                            'xl' => 6,
                        ]),
                    Forms\Components\Textarea::make('observacoes')
                        ->label('Observações')
                        ->autosize()
                        ->columnSpan(12),
                    Forms\Components\ToggleButtons::make('status')
                            ->hidden(fn($context) => $context === 'create')
                            ->label('Status do Atendimento')
                            ->inline()
                            ->options([
                                '1' => 'Agendado',
                                '2' => 'Agendamento Confirmado',
                                '3' => 'Agendamento Realizado',
                                '0' => 'Cancelada',
                            ])
                            ->icons([
                                '1' => 'heroicon-o-calendar',
                                '2' => 'heroicon-o-check-circle',
                                '3' => 'heroicon-o-check',
                                '0' => 'heroicon-o-x-circle',
                            ])
                            ->colors([
                                '1' => 'primary',
                                '2' => 'info',
                                '3' => 'success',
                                '0' => 'danger',
                            ])
                            ->default('1')
                            ->columnSpanFull()
                            ->required(false),
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
            DeleteAction::make(),
                
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
