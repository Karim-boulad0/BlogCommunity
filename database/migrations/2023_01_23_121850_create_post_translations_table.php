<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('post_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->string('locale')->index();
            $table->text('tags')->nullable();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('smallDesc')->nullable();
            $table->unique(['post_id', 'locale']);// yaeni mmno3 ytkararo
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('post_translations');
    }
};
