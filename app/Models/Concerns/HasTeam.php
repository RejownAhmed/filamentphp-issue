<?php

namespace App\Models\Concerns;

use App\Models\Team;
use Filament\Facades\Filament;
use Illuminate\Contracts\Database\Query\Builder;

trait HasTeam
{
    public static function bootHasTeam()
    {
        // Current tenant
        $tenant = Filament::getTenant();

        static::addGlobalScope('team', function (Builder $query) use ($tenant) {
            if (auth()->hasUser() && $tenant) {
                return $query->where('team_id', $tenant->id);
            }
        });

        static::creating(function ($model) use ($tenant) {
            if ($model->team_id === null) {
                $model->team_id = $tenant->id;
            }
        });

        static::saving(function ($model) use ($tenant) {
            if ($model->team_id === null) {
                $model->team_id = $tenant->id;
            }
        });
    }

    public function team()
    {
        return $this->belongsTo(Team::class);

    }

}
