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
        Schema::create('exam', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string("start_date");
            $table->integer("academic_year");
            $table->foreignId("class_id")->index();
            $table->foreign('class_id')->on('grade')->references('class_id');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
    **/

    public function down(): void
    {
        Schema::dropIfExists('exam');
    }
};
