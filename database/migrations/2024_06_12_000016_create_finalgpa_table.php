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
        Schema::create('finalgpa', function (Blueprint $table) {
            $table->id();
            $table->foreignId("exam_id")->index();
            $table->foreign('exam_id')->on('exam')->references('id');
            $table->float("cgpa",8,4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finalgpa');
    }
};
