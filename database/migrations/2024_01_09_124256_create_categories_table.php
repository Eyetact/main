<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('categories');
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
			$table->text('file');
			$table->foreignId('user_id')->constrained('users');
			$table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate()->cascadeOnDelete();
			$table->enum('enum', ['aya', 'alaa']);
			$table->enum('enum2', ['alaa', 'aya'])->default('aya');
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
        Schema::dropIfExists('categories');
    }
};
