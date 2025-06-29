<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'created_by')
                ->nullable()
                ->constrained();
            $table->foreignIdFor(Team::class)
                ->nullable()
                ->constrained();
            $table->string("name"); // individual, agencies
            $table->string("notes")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_categories');
    }
};