<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('wilmaferrells', 'wilmaferrell1s');
    }

    public function down()
    {
        Schema::rename('wilmaferrell1s', 'wilmaferrells');
    }
};