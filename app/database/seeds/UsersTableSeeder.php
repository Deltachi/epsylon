<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => "Student",
            'firstname' => "Max",
            'lastname' => "Mustermann",
            'matrikelnummer' => "123456789",
            'password' => Hash::make("123"),
            'role' => 'student',
        ]);
        DB::table('users')->insert([
            'username' => "Student 2",
            'firstname' => "Maike",
            'lastname' => "Mustermann",
            'matrikelnummer' => "111111119",
            'password' => Hash::make("123"),
            'role' => 'student',
        ]);
    }
}
