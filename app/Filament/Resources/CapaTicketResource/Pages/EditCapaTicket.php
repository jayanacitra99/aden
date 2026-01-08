<?php

namespace App\Filament\Resources\CapaTicketResource\Pages;

use App\Filament\Resources\CapaTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCapaTicket extends EditRecord
{
    protected static string $resource = CapaTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
