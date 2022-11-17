<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnyFieldTableVideoContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_contents', function (Blueprint $table) {
            $table->string('mime')->nullable()->after('kelas');
            $table->string('size')->nullable()->after('kelas');
            $table->string('path')->nullable()->after('kelas');
            $table->string('filename')->nullable()->after('kelas');
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
            $table->dropColumn([
                'mime',
                'size',
                'path',
                'filename',
            ]);
        });
    }
}
