<?php

namespace App\Filament\Resources\Workspace\Employee\EmployeeCategoryResource\Pages;

use App\Filament\Resources\Workspace\Employee\EmployeeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListEmployeeCategories extends ListRecords {
    protected static string $resource = EmployeeCategoryResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make()
                ->modalWidth(MaxWidth::Medium)
                ->icon('heroicon-o-plus-circle')
                ->label('Add New'),
        ];
    }
}
