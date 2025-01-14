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
        Schema::create('1_minute_charts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('time');
            $table->string('open');
            $table->string('high');
            $table->string('low');
            $table->string('close');
            $table->string('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('1_minute_charts');
    }
};
