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
    {   if (!Schema::hasColumn('m_lists', 'customer_group_id')){
            Schema::table('m_lists', function (Blueprint $table) {
                $table->integer('customer_group_id')->nullable();
            });
        }

        if (!Schema::hasColumn('m_lists', 'customer_id')){
            Schema::table('m_lists', function (Blueprint $table) {
                $table->integer('customer_id')->nullable();
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
        Schema::table('m_lists', function (Blueprint $table) {

        });
    }
};