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
            $table->float('total_credit', 8, 4)->after('IN_W'); 
            // $table->json('slugs')->nullable()->after('cover_image');

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
            $table->dropColumn('total_credit'); // Change to string 

        });  
    }
 
};
