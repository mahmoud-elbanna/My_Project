<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_verified_purchase')->default(false)->after('comment');
            $table->boolean('is_approved')->default(true)->after('is_verified_purchase');
            $table->integer('helpful_count')->default(0)->after('is_approved');
            $table->integer('unhelpful_count')->default(0)->after('helpful_count');
            $table->json('images')->nullable()->after('unhelpful_count');
        });

        Schema::create('review_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_helpful');
            $table->timestamps();

            $table->unique(['review_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_votes');
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['is_verified_purchase', 'is_approved', 'helpful_count', 'unhelpful_count', 'images']);
        });
    }
};
