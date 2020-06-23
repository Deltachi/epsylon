<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('type')->comment("Typ der Aufgabe, für das richtige parsen der JSON Daten.");
            $table->char('title', 100)->comment("Titel der Aufgabe");
            $table->longText('description')->comment("Aufgabenbeschreibung");
            $table->text('hint')->comment("Hinweis zur Aufgabe");
            $table->json('data')->nullable(true)->comment("Aufgabe im JSON-Format");
            $table->json('solution')->comment("Erwartungshorizont zur Aufgabe im JSON-Format");
            $table->float('points')->default(0.0)->comment("Maximal erreichbare Punkte dieser Aufgabe");
            $table->timestamps();
        });

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
                        "sentences" => "An _BLANK a day keeps the doctor away.",
                        "Honesty is the best _BLANK.",
                        "He who _BLANK last laughs longest.",
                        "Two _BLANK don't make it right.",
                        "words" => "policy", "banana", "rights", "laughs", "apple", "word",
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
