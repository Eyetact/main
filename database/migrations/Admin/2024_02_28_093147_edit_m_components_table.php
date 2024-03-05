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
    {   if (!Schema::hasColumn('m_components', 'usage_category_id')){
            Schema::table('m_components', function (Blueprint $table) {
                $table->foreignId('usage_category_id')->nullable()->constrained('usage_categories')->cascadeOnUpdate()->cascadeOnDelete();
			
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
        Schema::table('m_components', function (Blueprint $table) {

        });
    }
};
