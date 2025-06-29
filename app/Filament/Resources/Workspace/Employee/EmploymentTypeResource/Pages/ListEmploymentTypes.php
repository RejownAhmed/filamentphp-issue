<?php

namespace App\Filament\Resources\Workspace\Employee\EmploymentTypeResource\Pages;

use Filament\Actions;
use Filament\Support\Enums\MaxWidth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Workspace\Employee\EmploymentTypeResource;

class ListEmploymentTypes extends ListRecords {
    protected static string $resource = EmploymentTypeResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make()
                ->modalWidth( MaxWidth::Medium)
                ->icon('heroicon-o-plus-circle')
                ->label('Add New'),
        ];
    }
}
