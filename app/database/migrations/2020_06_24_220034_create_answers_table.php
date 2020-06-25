<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('user_id')->nullable(true)->comment("ID des User");
            $table->integer('exam_id')->nullable(true)->comment("ID des User");
            $table->integer('task_id')->nullable(true)->comment("ID des Task");
            $table->longText('user_solution')->nullable(true)->comment("Lösung im JSON-Format");
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
        Schema::dropIfExists('answers');
    }
}
