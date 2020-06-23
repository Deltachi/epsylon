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
                'points' => 2
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
                'points' => 10
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
                'title' => "Aufgabe 1: Welche Farben enthält die Flagge von Deutschland?",
                'description' => "Beschreibung der Aufgabe",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "solution" => ["blau","rot","gelb","weiß","schwarz"],
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
                'type' => 5,
                'title' => "Aufgabe1: Aufgabenstellung",
                'description' => "Beschreibung der Aufgabe",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "solution" => ["Lösung1", "Lösung2","Lösung3","Lösung4","Lösung5"],
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
                        "input" => ["Fakt 1", "Fakt 2", "Fakt 3", "Fakt 4"],
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
                'title' => "Bitte füllen Sie den Corona-Lückentext aus",
                'description' => "<p>Ordnen Sie die Antworten den passenden Aussagen zu.</p>",
                'hint' => "Hier steht ein Hinweis zur Aufgabe",
                'data' => json_encode(
                    array(
                        "sentences" => "Wenn jeder von uns zu Hause _BLANK sich ganz allein _BLANK dann können wir blank auch besiegen. Es geht _BLANK um mich um uns um jeden den man schützen _BLANK. Auch wenn die Zeiten _BLANK bleib zu Haus",
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
