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
            $table->json('data')->comment("Aufgabe im JSON-Format");
            $table->json('solution')->comment("Erwartungshorizont zur Aufgabe im JSON-Format");
            $table->timestamps();
        });

        DB::table('tasks')->insert(
          [
              'type' => 0,
              'title' => "Das hier ist eine Aufgabe mit vielen Fragen",
              'description' => "<p>In dieser Aufgabe sollst du Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, ut aliquip ex ea commodo consequat. Duis aute irure dolor anim id est laborum. machen.</p>",
              'hint' => "Hier steht ein Hinweis zur Aufgabe",
              'data' => json_encode(array("Subtasks"=> array(
                  array(
                      "id" => 0,
                      "title" => "Hier ist die Frage 1",
                      "hint" => "Hier ist der 1. Hinweis"
                  ),
                  array(
                      "id" => 1,
                      "title" => "Hier ist die Frage 2",
                      "hint" => "Hier ist der 2. Hinweis"
                  ),
                  array(
                      "id" => 2,
                      "title" => "Hier ist die Frage 3",
                      "hint" => "Hier ist der 3. Hinweis"
                  )
                )
              )),
              'solution' => json_encode(array("Subtasks"=> array(
                  array(
                      "id" => 0,
                      "solution" => "Lösung zur Aufgabe 1",
                      "points" => 2
                  ),
                  array(
                      "id" => 1,
                      "solution" => "Lösung zur Aufgabe 2",
                      "points" => 2
                  ),
                  array(
                      "id" => 2,
                      "solution" => "Lösung zur Aufgabe 3",
                      "points" => 3
                  )
              )
              )),
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
