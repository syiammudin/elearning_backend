<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtSomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_contents', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_contents', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
