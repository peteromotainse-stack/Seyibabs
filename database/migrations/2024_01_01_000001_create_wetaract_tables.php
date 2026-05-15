<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_handles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform');
            $table->string('handle');
            $table->timestamps();
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform');
            $table->string('action_type');
            $table->string('link');
            $table->text('description');
            $table->integer('total_slots');
            $table->integer('remaining_slots');
            $table->decimal('reward_value', 10, 2);
            $table->enum('reward_type', ['Points', 'Cash', 'Reciprocity'])->default('Points');
            $table->enum('campaign_type', ['Paid', 'Reciprocity'])->default('Paid');
            $table->boolean('use_ai')->default(false);
            $table->string('target_location')->default('Global');
            $table->decimal('budget', 10, 2)->nullable();
            $table->decimal('platform_fee', 10, 2)->nullable();
            $table->json('creator_interests')->nullable();
            $table->timestamps();
        });

        Schema::create('campaign_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['campaign_id', 'user_id']);
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['Earning', 'Withdrawal', 'Campaign_Spend', 'Deposit']);
            $table->string('description');
            $table->enum('status', ['Pending', 'Completed'])->default('Completed');
            $table->timestamps();
        });

        Schema::create('follows_pact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');
            $table->string('platform');
            $table->boolean('is_reciprocal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows_pact');
        Schema::dropIfExists('campaign_completions');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('social_handles');
    }
};
