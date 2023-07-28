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
        Schema::table('staff', function ($table) {
            $table->decimal('rank', 1, 1)->default(0.2)->change();
        });
    }
    // Schema::table('your_table_name', function (Blueprint $table) {
    //     $table->decimal('your_column_name', 8, 2)->change();
    // });
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->integer('rank')->change();
        });    
    }
};