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
        DB::table('exam_tasks')->insert([
            'exam_id' => 1,
            'task_id' => 1,
            'points' => 2.0,
        ]);
        DB::table('exam_tasks')->insert([
            'exam_id' => 1,
            'task_id' => 2,
            'points' => 10.0,
        ]);
        DB::table('exam_tasks')->insert([
            'exam_id' => 1,
            'task_id' => 3,
            'points' => 4.0,
        ]);
    }
}
