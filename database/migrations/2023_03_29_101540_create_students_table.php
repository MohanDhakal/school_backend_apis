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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('full_name');
            $table->string('image_uri')->nullable();            
            $table->integer('grade');
            $table->integer('current_rank')->nullable();
            $table->integer('roll_number')->nullable();
            $table->string('address');
            $table->string('email');
            $table->string('guardian_contact')->nullable();
            $table->date('dob');
            $table->date('joined_at');
            $table->string('major_subject');
            $table->boolean('is_active');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
