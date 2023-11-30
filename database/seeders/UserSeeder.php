<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            [
                'email' => 'admin@zent.vn',
            ],
            [
                'name' => 'Supper Admin',
                'email' => 'admin@zent.vn',
                'password' => Hash::make('Abc@1234'),
                'avatar' => null,
                'status' => User::STATUS['ACTIVE'],
            ]
        );
    }
}
