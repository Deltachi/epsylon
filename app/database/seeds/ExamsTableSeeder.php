<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $begin = new DateTime("2020-06-26T12:00:00Z");
        $end = new DateTime("2020-09-26T12:00:00Z");
        DB::table('exams')->insert([
            'subject_id'=>1,
            'title' => 'Klausur 1',
            'begin' => $begin->format("Y-m-d H:i:s"),
            'end' => $end->format("Y-m-d H:i:s"),
            'final' => true,
        ]);

        DB::table('exams')->insert([
            'subject_id'=>1,
            'title' => 'Klausur 2',
        ]);
    }
}
