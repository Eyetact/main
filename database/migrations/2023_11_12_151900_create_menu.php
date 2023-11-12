<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenu extends Migration
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
            $table->integer('module_id')->default(0);
            $table->string('menu_type');//storfront or admin
            $table->string('name');
            $table->string('code')->unique();
            $table->string('path');
            $table->integer('status')->default(0);
            $table->integer('include_in_menu')->default(0);
            $table->string('meta_title');
            $table->text('meta_description');
            $table->date('created_date');
            $table->text('assigned_attributes');
            $table->integer('sequence');
            $table->integer('parent');
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
        Schema::dropIfExists('Menu');
    }
}
