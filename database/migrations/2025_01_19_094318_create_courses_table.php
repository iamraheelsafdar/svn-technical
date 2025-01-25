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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stream_id');
            $table->foreign('stream_id')->references('id')->on('svn_streams')->onDelete('cascade');
            $table->unsignedBigInteger('prefix_id')->nullable();
            $table->foreign('prefix_id')->references('id')->on('prefixes')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->boolean('status')->default(1);
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->integer('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
