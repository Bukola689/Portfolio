<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory(10)->create();

        User::factory()->count(2)->create()->each(
            function($user) {
                $user->assignRole('admin');
            }
        );
    }
}
