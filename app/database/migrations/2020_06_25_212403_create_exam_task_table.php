<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_task', function (Blueprint $table) {
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('task_id')->constrained();
            $table->primary(array('exam_id','task_id'));
            $table->float('points')->nullable()->comment("Punkte, die diese Aufgabe in dieser Klausur bringen kann.");
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
        Schema::dropIfExists('exam_tasks');
    }
}
