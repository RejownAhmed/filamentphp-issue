<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Currencies: string implements HasLabel {
case BDT = 'BDT';
case USD = 'USD';
case EUR = 'EUR';
case GBP = 'GBP';
case INR = 'INR';

    public function getLabel(): string | null {
        return match ( $this ) {
            self::BDT => 'BDT',
            self::USD => 'USD',
            self::EUR => 'EUR',
            self::GBP => 'GBP',
            self::INR => 'INR',
        };
    }
}
