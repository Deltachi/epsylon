<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exam_user')->insert([
            'exam_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('exam_user')->insert([
            'exam_id' => 2,
            'user_id' => 1,
        ]);
    }
}
