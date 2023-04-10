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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('full_name');
            $table->date('dob');
            $table->string('level');//तह
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->string('image_uri');
            $table->string('post');//पद
            $table->integer('rank');//श्रेणी
            $table->string('major_in');
            $table->date('joined_at');
            $table->string('job_type');
            $table->boolean('is_active');            

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
