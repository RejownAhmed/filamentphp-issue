<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProjectType: string implements HasLabel {
case CLIENT   = 'client';
case IN_HOUSE = 'in_house';

    public function getLabel(): string | null {
        return match ( $this ) {
            self::CLIENT => 'Client',
            self::IN_HOUSE => 'In House',
        };
    }

    public function getColor(): string | null {
        return match ( $this ) {
            self::CLIENT => 'blue',
            self::IN_HOUSE => 'green',
        };
    }
}
