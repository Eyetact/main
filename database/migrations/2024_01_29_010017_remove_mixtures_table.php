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
        if (Schema::hasColumn('mixtures', 'aaaaaa')){
            Schema::table('mixtures', function (Blueprint $table) {
                $table->dropColumn('aaaaaa');
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
        Schema::table('mixtures', function (Blueprint $table) {

        });
    }
};
