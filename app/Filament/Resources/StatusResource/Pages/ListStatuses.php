<?php

namespace App\Filament\Resources\StatusResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StatusResource;

class ListStatuses extends ListRecords
{
    protected static string $resource = StatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalWidth(MaxWidth::Medium)
            ->icon('heroicon-o-plus-circle')
            ->label('Add New'),
        ];
    }
}
