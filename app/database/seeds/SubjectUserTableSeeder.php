<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subject_user')->insert([
            'subject_id' => 1,
            'user_id' => 3,
        ]);
    }
}
