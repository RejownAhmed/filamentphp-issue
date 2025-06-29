<?php

namespace App\Models\Workspace\Employee;

use App\Models\Concerns\HasTeam;
use App\Models\Workspace\Employee\EmployeeCategory;
use App\Models\Workspace\Employee\EmploymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia {
    use InteractsWithMedia, HasTeam;

    protected $fillable = [
        'created_by',
        'name',
        'designation',
        'email',
        'phone_country',
        'phone_number',
        'address',
        'employment_type_id',
        'employee_category_id',
        'notes',
        'join_date',
        'team_id',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function getProfilePictureAttribute() {
        return $this->getFirstMediaUrl( "profile_picture" ) ?: asset( "images/profile-placeholder-square.jpg" );
    }

    public function attachments() {
        return $this->media()
            ->where( "collection_name", "attachments" );

    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection( "profile_picture" )
            ->singleFile()
            ->acceptsMimeTypes( ["image/png", "image/jpeg", "image/webp", "image/jpg"] );

        $this->addMediaCollection( "attachments" )
            ->acceptsMimeTypes( ["image/png", "image/jpeg", "image/webp", "image/jpg"] );

    }

    public function employmentType(): BelongsTo {
        return $this->belongsTo( EmploymentType::class, 'employment_type_id', 'id' );
    }

    public function employeeCategory(): BelongsTo {
        return $this->belongsTo( EmployeeCategory::class, 'employee_category_id', 'id' );
    }
}
