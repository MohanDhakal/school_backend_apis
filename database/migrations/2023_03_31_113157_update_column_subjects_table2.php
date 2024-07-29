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
        Schema::table('subjects', function ($table) {
            $table->string("sub_code")->after('of_grade');
            $table->string('TH_W')->after('sub_code');
            $table->string('IN_W')->after('TH_W');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('sub_code');
            $table->dropColumn('TH_W');
            $table->dropColumn('IN_W');
        });  
    }
 
};
