<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasTeam;

class Status extends Model
{
    use HasTeam;

    protected $fillable = ["created_by", "name", "label","group","color", "notes",'team_id'];

}