<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Workspace\Employee\EmployeeCategory;
use App\Models\Workspace\Employee\EmploymentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up() {
        Schema::create( 'employees', function ( Blueprint $table ) {
            $table->id();
            $table->foreignIdFor( User::class, 'created_by' )
                ->nullable()
                ->constrained();
            $table->foreignIdFor( Team::class )
                ->nullable()
                ->constrained();
            $table->string( 'name' );
            $table->string( 'designation' )->nullable();
            $table->string( 'email' )->nullable();
            $table->string( 'phone_country' )->nullable();
            $table->string( 'phone_number' )->nullable();
            $table->text( 'address' )->nullable();
            $table->foreignIdFor( EmploymentType::class )
                ->constrained();
            $table->foreignIdFor( EmployeeCategory::class )
                ->constrained();
            $table->text( 'notes' )
                ->nullable();
            $table->date( 'join_date' );
            $table->timestamps();
        } );
    }

    public function down() {
        Schema::dropIfExists( 'employees' );
    }
};
