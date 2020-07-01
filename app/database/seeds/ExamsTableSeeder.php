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
        $end = new DateTime("2020-07-02T11:00:00Z");
        DB::table('exams')->insert([
            'subject_id'=>1,
            'title' => 'Klausur 1',
            'begin' => $begin->format("Y-m-d H:i:s"),
            'end' => $end->format("Y-m-d H:i:s"),
            'status' => 'pending',
            'final' => true,
            'terms' => "<ul><li>Achten Sie auf Lesbarkeit und Nachvollziehbarkeit Ihrer Antworten und Lösungswege.</li><li>Hilfsmittel sind nicht erlaubt (zugelassen sind nicht programmierbare Taschenrechner).</li><li>Diese Klausur besteht aus sieben Aufgaben auf 18 Seiten.</li><li>Bitte kontrollieren Sie die Vollständigkeit des an Sie ausgegebenen Klausurexemplars.</li><li>Bitte prüfen Sie, ob alle Seiten ihrer Lösung korrekt hochgeladen wurden.</li></ul>",
        ]);

        $begin = new DateTime("2020-09-13T10:00:00Z");
        $end = new DateTime("2020-09-13T11:30:00Z");
        DB::table('exams')->insert([
            'subject_id'=>1,
            'title' => 'Klausur 2',
            'begin' => $begin->format("Y-m-d H:i:s"),
            'end' => $end->format("Y-m-d H:i:s"),
            'status' => 'pending',
            'final' => true,
            'terms' => "<ul><li>Achten Sie auf Lesbarkeit und Nachvollziehbarkeit Ihrer Antworten und Lösungswege.</li><li>Hilfsmittel sind nicht erlaubt (zugelassen sind nicht programmierbare Taschenrechner).</li><li>Diese Klausur besteht aus sieben Aufgaben auf 18 Seiten.</li><li>Bitte kontrollieren Sie die Vollständigkeit des an Sie ausgegebenen Klausurexemplars.</li><li>Bitte prüfen Sie, ob alle Seiten ihrer Lösung korrekt hochgeladen wurden.</li></ul>",
        ]);

        DB::table('exams')->insert([
            'subject_id'=>1,
            'title' => 'Klausur 2 (Kopie)',
        ]);
    }
}
