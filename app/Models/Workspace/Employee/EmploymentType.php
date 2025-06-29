<?php

namespace App\Models\Workspace\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasTeam;

class EmploymentType extends Model
{
    use HasTeam;

    protected $fillable = ['name', 'created_by', 'notes', 'team_id'];

}
