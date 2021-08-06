<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_gallery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                    ->constrained('posts')
                    ->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('video_id')->nullable(); //es el id del video
            $table->tinyInteger('position');
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
        Schema::dropIfExists('posts_gallery');
    }
}
