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
        Schema::create('std_contact', function (Blueprint $table) {
            $table->id("contact_id");
            $table->foreignId('student_id')->index();
            $table->foreign('student_id')->on('students')->references('student_id');
            $table->string('email');
            $table->string('phone_number');
            $table->string('guardian_contact_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('std_contact');
    }
};
