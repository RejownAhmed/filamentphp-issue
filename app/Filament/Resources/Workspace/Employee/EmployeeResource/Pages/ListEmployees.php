<?php

namespace App\Filament\Resources\Workspace\Employee\EmployeeResource\Pages;

use App\Filament\Resources\Workspace\Employee\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus-circle')
            ->label('Add New'),
        ];
    }
}
