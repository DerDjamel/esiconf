<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('abstract');
            $table->text('comment')->nullable();
            $table->string('path');
            // $table->string('keywords');
            // status has 4 defaults => waiting, in revision, rejected, accepted
            $table->string('status')->default('waiting');

            //add teh uploaded file path in here

            $table->unsignedBigInteger('conference_id');
            $table->foreign('conference_id')->references('id')->on('conferences');
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
        Schema::dropIfExists('papers');
    }
}
