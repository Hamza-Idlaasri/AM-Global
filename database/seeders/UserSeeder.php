<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $connection = 'users';

    public function run()
    {
        $agent = User::create([
            'name' => 'agent',
            'email' => 'agent@gmail.com',
            'phone_number' => '212611111111',
            'notified' => 0,
            'password' => Hash::make('agent'),
        ]);

    }
}
