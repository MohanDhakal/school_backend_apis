<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId("exam_id")->index();
            $table->foreign('exam_id')->on('exam')->references('id');
            $table->foreignId("student_id")->index();
            $table->foreign('student_id')->on('students')->references('student_id');
            $table->foreignId("subject_id")->index();
            $table->foreign('subject_id')->on('subjects')->references('subject_id');
            $table->string("marks_type");
            $table->float("marks", 8, 2);
            $table->string("grade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
