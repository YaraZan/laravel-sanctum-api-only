<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->withRole('root')->create([
            'name' => config('app.root_user.name'),
            'email' => config('app.root_user.email'),
            'password' => Hash::make(config('app.root_user.password')),
        ]);
    }
}
