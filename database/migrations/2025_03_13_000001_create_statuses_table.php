<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'statuses', function ( Blueprint $table ) {
            $table->id();
            $table->foreignIdFor( User::class, 'created_by' )
                ->nullable()
                ->constrained();
            $table->foreignIdFor( Team::class )
                ->nullable()
                ->constrained();
            $table->string( "name" );
            $table->string( "label" );
            $table->string( "group" )->nullable(); // StatusGroup Enum
            $table->string( "color" )->nullable();
            $table->string( "notes" )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'statuses' );
    }
};