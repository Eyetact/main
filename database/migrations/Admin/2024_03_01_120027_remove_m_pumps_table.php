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
        if (Schema::hasColumn('m_pumps', 'usage_category_id')){
            Schema::table('m_pumps', function (Blueprint $table) {
                $table->dropForeign('m_pumps_usage_category_id_foreign');
$table->dropColumn('usage_category_id');
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
