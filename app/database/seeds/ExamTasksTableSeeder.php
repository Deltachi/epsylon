<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTasksTableSeeder extends Seeder
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
            'task_id' => 1,
            'points' => 10.0,
        ]);
    }
}
