<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment("Typ der Subtask, für das richtige parsen der JSON Daten.");
            $table->char('title', 100)->comment("Titel der Subtask");
            $table->longText('description')->comment("Aufgabenbeschreibung");
            $table->text('hint')->comment("Hinweis zur Aufgabe");
            $table->json('data');
            $table->json('solution');
            $table->timestamps();

            $table->foreignId('task_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtasks');
    }
}
