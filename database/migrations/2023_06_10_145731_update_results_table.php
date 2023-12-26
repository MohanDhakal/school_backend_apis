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
        Schema::table('results', function ($table) {
            $table->integer('grade')->after('student_id');
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
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn('grade');
        });    
    }
};
