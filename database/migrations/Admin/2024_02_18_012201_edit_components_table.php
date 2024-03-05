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
        if (!Schema::hasColumn('components', 'units_id')){
            Schema::table('components', function (Blueprint $table) {
                $table->foreignId('units_id')->nullable()->constrained('units')->cascadeOnUpdate()->cascadeOnDelete();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('components', function (Blueprint $table) {

        });
    }
};
