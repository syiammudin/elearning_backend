<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnyFieldTableExam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->double('score')->nullable();
            $table->boolean('passed')->nullable();
            $table->boolean('status')->default(false);
            $table->double('cuntdown_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn([
                'score',
                'passed',
                'status',
                'cuntdown_time',
            ]);
        });
    }
}
