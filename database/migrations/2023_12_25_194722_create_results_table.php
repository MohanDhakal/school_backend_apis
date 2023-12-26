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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->foreignId("student_id")->index();
            $table->foreign('student_id')->on('students')->references('student_id');
            $table->integer("academic_year");            
            $table->integer("term");
            $table->foreignId("subject_id")->index();
            $table->foreign('subject_id')->on('subjects')->references('subject_id');
            $table->integer("full_marks");
            $table->integer("pass_marks");
            $table->integer("obtained_marks");
            $table->integer("remarks");
 
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
