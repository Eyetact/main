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
    {   if (!Schema::hasColumn('m_lists', 'm_creation_id')){
            Schema::table('m_lists', function (Blueprint $table) {
                $table->foreignId('m_creation_id')->nullable()->constrained('m_creations')->cascadeOnUpdate()->cascadeOnDelete();
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
