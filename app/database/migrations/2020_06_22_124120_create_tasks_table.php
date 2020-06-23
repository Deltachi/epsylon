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
