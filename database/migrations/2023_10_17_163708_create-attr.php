<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('field_type');
            $table->string('input_name')->nullable();
            $table->string('input_class')->nullable();
            $table->string('input_id')->nullable();
            $table->boolean('is_required')->default(0)->comment('0: not required, 1: required');
            $table->string('validation_message')->nullable();
            $table->json('fields_info')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_enable')->default(1)->comment('0: disable, 1: enable');
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
        Schema::dropIfExists('attributes');
    }
}
