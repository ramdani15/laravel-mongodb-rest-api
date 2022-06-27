<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = 'password123';

        User::create([
            'username' => 'super',
            'name' => 'Super Admin',
            'email' => 'super@laramongo.com',
            'email_verified_at' => time(),
            'password' => bcrypt($password),
        ]);

        User::factory(10)->create([
            'password' => bcrypt($password),
        ]);
    }
}
