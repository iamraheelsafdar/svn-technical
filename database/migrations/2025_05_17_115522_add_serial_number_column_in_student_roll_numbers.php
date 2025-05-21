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
        Schema::table('student_roll_numbers', function (Blueprint $table) {
            $table->integer('serial_number')->after('student_id')->nullable();
            $table->integer('old_roll_number_id')->after('serial_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_roll_numbers', function (Blueprint $table) {
            $table->dropColumn('serial_number');
            $table->dropColumn('old_roll_number_id');
        });
    }
};
