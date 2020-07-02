<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained();
            $table->text('title')->default('Neue Klausur');
            $table->enum('status',['draft','pending','open','closed','finished'])->default('draft')->comment("Nicht freigegeben, Freigegeben (wartet), Bearbeitet möglich, Bearbeitung nicht mehr möglich, Bewertet");
            $table->boolean('final')->default(false)->comment("Wenn eine Klausur nach der Erstellung freigegeben wird, darf diese nicht mehr verändert werden");
            $table->timestamp('begin')->nullable()->comment("Startzeitpunkt der Klausur");
            $table->timestamp('end')->nullable()->comment("Endzeitpunkt der Klausur");
            $table->boolean('reenter')->default(true)->comment("Darf der Student die Klausur (im Zeitrahmen) nochmal öffnen, nachdem sie abgegeben wurde?");
            $table->text('terms')->nullable()->comment('Die allgemeinen Hinweise zur Klausur');
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
        Schema::dropIfExists('exams');
    }
}
