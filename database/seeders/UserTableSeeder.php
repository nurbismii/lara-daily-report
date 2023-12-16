<?php

namespace Database\Seeders;

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
        \App\Models\user::create(
            [
                'nik' => '11110000',
                'name' => 'Admin HR',
                'email' => 'admin@vdni.my.id',
                'password' => bcrypt('12345678'),
            ],
        );
    }
}
