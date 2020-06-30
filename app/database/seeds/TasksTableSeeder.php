<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert(
            [
                'type' => 1,
                'title' => "Aufgabentyp 1: Textfenster",
                'description' => "<p>In dieser Aufgabe sollst du Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, ut aliquip ex ea commodo consequat. Duis aute irure dolor anim id est laborum. machen.</p>",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => null,
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 5
            ]
        );

        DB::table('tasks')->insert(
            [
                'type' => 2,
                'title' => "Das hier ist eine Programmier-Aufgabe in C++",
                'description' => "<p>Hier ist eine detaillierte Beschreibung der Aufgabe</p><ul><li>Aufgabe 1.1</li><li>Aufgabe 1.2</li><li>Aufgabe 1.3</li></ul>",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "code" => 'int x = 0;\nint myFunc(int a, int b){\n    int out = a + b;\n    return out;\n}'
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 20
            ]
        );
        DB::table('tasks')->insert(
            [
                'type' => 3,
                'title' => "Drag und Drop Aufgabe",
                'description' => "<p>Fill in the blanks by dragging the missing answer.</p>",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "sentences" => ["An _BLANK a day keeps the doctor away.", "Honesty is the best _BLANK.", "He who _BLANK last laughs longest.", "Two _BLANK don't make it right."],
                        "words" => ["policy", "banana", "rights", "laughs", "apple", "word"],
                        "blank" => "_BLANK",
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 10
            ]
        );

        DB::table('tasks')->insert(
            [
                'type' => 4,
                'title' => "Checkbox: Welche Farben enthält die Flagge von Deutschland?",
                'description' => "Beschreibung der Aufgabe",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "blau","rot","gelb","weiß","schwarz"
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 5
            ]
        );
        DB::table('tasks')->insert(
            [
                'type' => 5,
                'title' => "Multiple Choice: Aufgabenstellung",
                'description' => "Beschreibung der Aufgabe",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "Auswahl 1", "Auswahl 2","Auswahl 3","Auswahl 4","Auswahl 5",
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 5
            ]
        );
        DB::table('tasks')->insert(
            [
                'type' => 6,
                'title' => "Finden Sie die richtige Reihenfolge",
                'description' => "<p>Sortieren Sie die Antworten von wichtigster Bedeutung zu unwichtigster.</p>",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "solution1" => ["name" => "Option1", "hint" => "Hinweis1"],
                        "solution2" => ["name" => "Option2", "hint" => "Hinweis2"],
                        "solution3" => ["name" => "Option3", "hint" => "Hinweis3"],
                        "top" => "wichtig",
                        "bottom" => "unwichtig",
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 10
            ]
        );
        DB::table('tasks')->insert(
            [
                'type' => 7,
                'title' => "Welche Antworten passen zu welchen Aussagen?",
                'description' => "<p>Ordnen Sie die Antworten den passenden Aussagen zu.</p>",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "input" => ["Fakt 1", "Fakt 2", "Fakt 3", "Fakt 4", "Fakt 5"],
                        "output" => ["Aussage 1", "Aussage 2", "Aussage 3",]
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 10
            ]
        );
        DB::table('tasks')->insert(
            [
                'type' => 8,
                'title' => "Bitte füllen Sie den Lückentext aus",
                'description' => "<p>Was sind die Grundregeln für richtiges Händewaschen?</p>",
                'hint' => "https://www.blanco.com/de-de/inspirationen/haendewaschen/",
                'data' => json_encode(
                    array(
                        "sentence" => "Waschen Sie Ihre Hände gründlich mit Wasser und _BLANK. Für das Händewaschen sollte man sich mindestens _BLANK Sekunden Zeit nehmen. Denken Sie dabei daran, nicht nur die Handinnenflächen, sondern auch die _BLANK, die _BLANK und _BLANK der Finger gründlich einzuseifen.",
                        "blank" => "_BLANK"
                    )
                ),
                'solution' => json_encode(
                    array(
                        "erwartungshorizont" => "Lösung zur Aufgabe 1",
                    )
                ),
                'points' => 10
            ]
        );
    }
}
