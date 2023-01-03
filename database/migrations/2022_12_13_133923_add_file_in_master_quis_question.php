<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileInMasterQuisQuestion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_quiz_questions', function (Blueprint $table) {
            $table->text('name')->nullable();
            $table->text('path')->nullable();
            $table->string('size')->nullable();
            $table->string('mime')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_quiz_questions', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'path',
                'size',
                'mime',
                'type',
            ]);
        });
    }
}
