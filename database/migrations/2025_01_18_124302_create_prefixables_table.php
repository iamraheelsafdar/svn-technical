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
        Schema::create('prefixables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prefix_id')->constrained()->onDelete('cascade');
            $table->morphs('prefixable'); // Creates prefixable_id and prefixable_type columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefixables');
    }
};
