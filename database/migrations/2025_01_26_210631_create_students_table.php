<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('enrollment')->nullable();
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('admission_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('state')->nullable();
            $table->string('mode')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('qualification')->nullable();
            $table->string('identity_card')->nullable();
            $table->boolean('lateral_entry')->default(false);
            $table->string('lateral_duration')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
