<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\Contracts\HasAvatar;
use App\Models\Workspace\Employee\Employee;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Workspace\Employee\EmploymentType;
use App\Models\Workspace\Employee\EmployeeCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model implements HasMedia, HasAvatar
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'created_by'];

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getLogoUrl();
    }

    public function getLogoUrl()
    {
        return $this->getFirstMediaUrl("logo") ?: asset("images/profile-placeholder-square.jpg");
    }

    public function attachments()
    {
        return $this->media()
            ->where("collection_name", "attachments");

    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("logo")
            ->singleFile()
            ->acceptsMimeTypes(["image/png", "image/jpeg", "image/webp", "image/jpg"]);

        $this->addMediaCollection("attachments")
            ->acceptsMimeTypes(["image/png", "image/jpeg", "image/webp", "image/jpg"]);

    }

    // User relationships
    public function users()
    {
        return $this->belongsToMany(User::class);

    }

    // Roles and Permissions
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    // Employee module relationships
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function employeeCategories()
    {
        return $this->hasMany(EmployeeCategory::class);
    }

    public function employmentTypes()
    {
        return $this->hasMany(EmploymentType::class);

    }

    public function statuses()
    {
        return $this->hasMany(Status::class);

    }

    public function seedDefaultData()
    {
        $this->statuses()->createMany([
            [
                'name' => 'active',
                'label' => "Active",
                'group' => "employee",
                'color' => "success",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'paused',
                'label' => "Paused",
                'group' => "employee",
                'color' => "warning",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cancelled',
                'label' => "Cancelled",
                'group' => "employee",
                'color' => "danger",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
