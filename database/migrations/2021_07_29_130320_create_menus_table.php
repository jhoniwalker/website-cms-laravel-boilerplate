<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->unsignedInteger('parent')->default(0);
            $table->string('slug', 150)->unique();
            $table->string('type', 50);
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('intro')->nullable();
            $table->text('body')->nullable();
            $table->string('link')->nullable();
            $table->string('target', 50)->nullable();                
            $table->boolean('published')->default(0);
            $table->boolean('issyst')->default(0);            
            $table->smallInteger('position')->default(0);
            $table->boolean('onmenu')->default(0);    
            $table->boolean('onfooter')->default(0);  
            $table->boolean('onheader')->default(0);      
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
        Schema::dropIfExists('menus');
    }
}
