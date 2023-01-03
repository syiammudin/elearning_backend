<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('exam_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->integer('nomor')->nullable();
            $table->text('question')->nullable();
            $table->json('choices')->nullable();
            $table->text('correct_answer')->nullable();
            $table->text('user_answer')->nullable();
            $table->boolean('status')->nullable();
            $table->text('path')->nullable();
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
        Schema::dropIfExists('exam_quizzes');
    }
}
