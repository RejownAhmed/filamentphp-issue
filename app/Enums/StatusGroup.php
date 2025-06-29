<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StatusGroup: string implements HasLabel {
    // Add All Module names
case CLIENT   = 'client';
case EMPLOYEE = 'employee';
case EXPENSE  = 'expense';
case INCOME   = 'income';
case PARTNER  = 'partner';
case PROJECT  = 'project';
case SERVICE  = 'service';
case TASK     = 'task';

    public function getLabel(): string {
        return match ( $this ) {
            self::CLIENT => 'Client',
            self::EMPLOYEE => 'Employee',
            self::EXPENSE => 'Expense',
            self::INCOME => 'Income',
            self::PARTNER => 'Partner',
            self::PROJECT => 'Project',
            self::SERVICE => 'Service',
            self::TASK => 'Task',
        };
    }

}
