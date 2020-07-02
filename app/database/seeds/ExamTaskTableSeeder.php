<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 1,
            'points' => 2.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 2,
            'points' => 10.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 3,
            'points' => 4.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 4,
            'points' => 4.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 5,
            'points' => 8.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 6,
            'points' => 6.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 7,
            'points' => 9.0,
        ]);
        DB::table('exam_task')->insert([
            'exam_id' => 1,
            'task_id' => 8,
            'points' => 15.0,
        ]);
    }
}
