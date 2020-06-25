<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exam_users')->insert([
            'exam_id' => 1,
            'user_id' => 1,
        ]);
    }
}
