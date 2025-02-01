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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('duration_part')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('min_marks')->nullable();
            $table->string('max_marks')->nullable();
            $table->boolean('is_practical')->default(0);
            $table->string('practical_min_marks')->nullable();
            $table->string('practical_max_marks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
