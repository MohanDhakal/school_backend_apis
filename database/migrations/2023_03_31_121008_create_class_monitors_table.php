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
        Schema::create('class_monitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cm_id')->index();
            $table->foreign('cm_id')->references('student_id')->on('students');
            $table->integer('for_grade');
            $table->date('from_date');
            $table->date('to_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_monitors');
    }
};
