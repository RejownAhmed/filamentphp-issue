<?php

namespace App\Models\Workspace\Employee;

use App\Models\Concerns\HasTeam;
use Illuminate\Database\Eloquent\Model;

class EmployeeCategory extends Model
{
    use HasTeam;

    protected $table = 'employee_categories';
    protected $fillable = ['created_by', 'name', 'notes', 'team_id'];

}
