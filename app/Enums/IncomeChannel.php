<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IncomeChannel: string implements HasLabel
{
case SERVICE = 'service';
case PROJECT = 'project';

    public function getLabel(): string {
        return match ( $this ) {
            self::SERVICE => 'Service',
            self::PROJECT => 'Project',
        };
    }

    public function getColor(): string {
        return match ( $this ) {
            self::SERVICE => 'blue',
            self::PROJECT => 'green',
        };
    }

}
