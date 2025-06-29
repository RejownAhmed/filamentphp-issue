<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExpenseType: string implements HasLabel
{
case EMPLOYEE = 'employee';
case PROJECT  = 'project';
case PARTNER  = 'partner';
case UTILITY  = 'utility';
case OTHER    = 'other';

    public function getLabel(): string {
        return match ( $this ) {
            self::EMPLOYEE => 'Employee',
            self::PROJECT => 'Project',
            self::UTILITY => 'Utility',
            self::PARTNER => 'Partner',
            self::OTHER => 'Other',
        };
    }

    public function getColor(): string {
        return match ( $this ) {
            self::EMPLOYEE => 'blue',
            self::PROJECT => 'green',
            self::PARTNER => 'lime',
            self::UTILITY => 'yellow',
            self::OTHER => 'gray',
        };
    }
}
