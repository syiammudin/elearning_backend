<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_boxes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('searcable');
            $table->text('descryption')->nullable();
            $table->text('tag')->nullable();
            $table->text('title')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('search_boxes');
    }
}
