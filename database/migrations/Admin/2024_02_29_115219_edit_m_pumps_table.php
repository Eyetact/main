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
    {   if (!Schema::hasColumn('m_pumps', 'm_pump_flowrate')){
            Schema::table('m_pumps', function (Blueprint $table) {
                $table->double('m_pump_flowrate')->nullable();
			
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
        Schema::table('m_pumps', function (Blueprint $table) {

        });
    }
};
