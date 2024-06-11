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
        Schema::table('students', function ($table) {
            $table->foreignId('class_id')->index();
            $table->foreign('class_id')->on('grade')->references('class_id');      
            $table->foreignId('contact_id')->index();
            $table->foreign('contact_id')->on('std_contact')->references('contact_id');  

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         // Drop foreign key constraints
         Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropForeign(['contact_id']);
            $table->dropColumn('class_id');
            $table->dropColumn('contact_id');
        });
    }
};
