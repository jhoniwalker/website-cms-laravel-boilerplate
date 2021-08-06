<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus_gallery', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')
                    ->constrained('menus')
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
        Schema::dropIfExists('menus_gallery');
    }
}
