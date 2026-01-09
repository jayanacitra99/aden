<?php

namespace App\Filament\Resources\MonthlySummaryResource\Pages;

use App\Filament\Resources\MonthlySummaryResource;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\ListRecords;

class ListMonthlySummaries extends ListRecords
{
    protected static string $resource = MonthlySummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(), // Creating is disabled in resource
        ];
    }

    protected function getTableColumnToggleFormSchema(): array
    {
        $schema = parent::getTableColumnToggleFormSchema();

        return [
            Checkbox::make('toggle_all')
                ->label('Select / Deselect All')
                ->live()
                ->afterStateUpdated(function ($state, $set) {
                    foreach ($this->getTable()->getColumns() as $column) {
                        if ($column->isToggleable()) {
                            $set($column->getName(), $state);
                        }
                    }
                })
                ->dehydrated(false)
                ->columnSpanFull()
                ->extraAttributes(['class' => 'border-b pb-4 mb-4']),
            Section::make('Columns')
                ->schema($schema)
                ->columns(3)
                ->compact()
                ->columnSpanFull(),
        ];
    }
}
