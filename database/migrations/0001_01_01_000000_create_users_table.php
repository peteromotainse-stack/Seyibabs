<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('membership_status', ['INACTIVE', 'PENDING', 'ACTIVE'])->default('INACTIVE');
            $table->boolean('is_elite_verified')->default(false);
            $table->integer('points')->default(0);
            $table->decimal('wallet_balance', 15, 2)->default(0.00);
            $table->decimal('total_withdrawn', 15, 2)->default(0.00);
            $table->integer('following_count')->default(0);
            $table->integer('followers_count')->default(0);
            $table->json('interests')->nullable();
            $table->string('referral_code')->unique()->nullable();
            $table->string('referred_by')->nullable();
            $table->integer('total_referrals')->default(0);
            $table->decimal('referral_earnings', 15, 2)->default(0.00);
            $table->decimal('referral_pending', 15, 2)->default(0.00);
            $table->integer('warnings')->default(0);
            $table->integer('visibility_score')->default(50);
            $table->decimal('engagement_rate', 5, 2)->default(0.00);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
