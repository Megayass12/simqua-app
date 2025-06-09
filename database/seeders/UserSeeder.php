<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'murottilil.id@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'email' => 'megachan@gmail.com',
            'password' => Hash::make('megachan'),
        ]);
    }
}
