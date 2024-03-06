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
        if (Schema::hasColumn('compo_feeds', 'compo_feed_cat')){
            Schema::table('compo_feeds', function (Blueprint $table) {
                $table->dropColumn('compo_feed_cat');
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
        Schema::table('compo_feeds', function (Blueprint $table) {

        });
    }
};
