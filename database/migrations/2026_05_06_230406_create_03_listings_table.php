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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scan_run_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_id')->nullable();
            $table->string('external_hash')->unique();
            $table->text('url');
            $table->string('title');
            $table->unsignedInteger('price_eur')->nullable();
            $table->string('location')->nullable();
            $table->string('seller_name')->nullable();
            $table->string('status')->default('active');
            $table->text('description')->nullable();
            $table->json('detected_specs')->nullable();
            $table->json('image_urls')->nullable();
            $table->unsignedTinyInteger('hardware_score')->nullable();
            $table->unsignedTinyInteger('value_score')->nullable();
            $table->unsignedTinyInteger('risk_score')->nullable();
            $table->string('verdict')->nullable();
            $table->decimal('confidence', 3, 2)->nullable();
            $table->json('red_flags')->nullable();
            $table->json('pros')->nullable();
            $table->json('cons')->nullable();
            $table->json('questions_to_ask')->nullable();
            $table->text('ai_summary')->nullable();
            $table->timestamp('first_seen_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();

            $table->index(['source_id', 'status']);
            $table->index(['verdict', 'value_score']);
            $table->index('last_seen_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
