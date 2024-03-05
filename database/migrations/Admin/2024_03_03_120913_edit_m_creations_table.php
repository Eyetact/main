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
    {   if (!Schema::hasColumn('m_creations', 'm_pump_id')){
            Schema::table('m_creations', function (Blueprint $table) {
                $table->foreignId('m_pump_id')->nullable()->constrained('m_pumps')->cascadeOnUpdate()->cascadeOnDelete();
			
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
        Schema::table('m_creations', function (Blueprint $table) {

        });
    }
};
