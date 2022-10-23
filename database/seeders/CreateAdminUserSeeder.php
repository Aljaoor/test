<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'mohammed',
            'last_name' => 'aljaoor',
            'emailOrNumber' => 'mohammed.aljaoor6@gmail.com',
            'password' => Hash::make('11111111'),
            'role_id' => 2,


        ]);



    }
}
