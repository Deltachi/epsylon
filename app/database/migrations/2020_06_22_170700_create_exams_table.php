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
            $table->text('title');
            $table->enum('status',['draft','pending','open','closed','finished'])->default('pending')->comment("Noch nicht freigegeben, Kann geschrieben werden, Bearbeitung nicht mehr möglich, Bewertung abgeschlossen");
            $table->boolean('final')->default(false)->comment("Wenn eine Klausur freigegeben wird, darf diese nicht mehr verändert werden");
            $table->timestamp('begin')->nullable()->comment("Startzeitpunkt der Klausur");
            $table->timestamp('end')->nullable()->comment("Endzeitpunkt der Klausur");
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
