<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Need to complete admin dashboard as well
        // $admin = User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@managepro.com',
        //     'password' => 'password',
        // ]);

        $admin = User::factory()->create( [
            'name'     => 'Customer',
            'email'    => 'user@demo.com',
            'password' => '123456',
        ] );

        $team = Team::create( [
            'id'   => 1, // specific id because you need it later
            'name' => 'Default Team',
            'slug' => 'default-team',
        ] );

        $team->users()->attach( $admin->id );

        $team->seedDefaultData();

    }
}
