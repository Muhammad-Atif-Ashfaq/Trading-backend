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
        Schema::create('trading_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trading_group_id')->nullable();
            $table->string('brand_id');
            $table->string('brand_customer_id')->nullable();
            $table->string('public_key')->nullable();
            $table->string('login_id')->nullable();
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('leverage')->nullable();
            $table->string('balance')->default('0');
            $table->string('credit')->default('0');
            $table->string('bonus')->default('0');
            $table->string('commission')->default('0');
            $table->string('tax')->default('0');
            $table->string('equity')->nullable();
            $table->string('margin_level_percentage')->default('0');
            $table->string('free_margin')->default('0');
            $table->json('symbols_leverage')->nullable();
            $table->string('profit')->default('0');
            $table->string('swap')->nullable();
            $table->string('currency')->nullable();
            $table->string('registration_time')->nullable();
            $table->timestamp('last_access_time')->nullable();
            $table->string('last_access_address_IP')->nullable();
            $table->boolean('enable_password_change')->default(0);
            $table->boolean('enable_investor_trading')->default(0);
            $table->boolean('change_password_at_next_login')->default(0);
            $table->boolean('enable')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_accounts');
    }
};
