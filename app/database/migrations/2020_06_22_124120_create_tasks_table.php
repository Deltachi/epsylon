<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->id();
            $table->integer('type')->comment("Typ der Aufgabe, für das richtige parsen der JSON Daten.");
            $table->char('title', 100)->comment("Titel der Aufgabe");
            $table->longText('description')->comment("Aufgabenbeschreibung");
            $table->text('hint')->comment("Hinweis zur Aufgabe");
            $table->json('data')->comment("Aufgabe im JSON-Format");
            $table->json('solution')->comment("Erwartungshorizont zur Aufgabe im JSON-Format");
            $table->timestamps();
        });
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
