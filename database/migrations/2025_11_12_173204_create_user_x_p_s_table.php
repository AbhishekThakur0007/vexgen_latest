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
        Schema::create('user_xps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('xp_amount')->default(0);
            $table->string('source_type')->nullable(); // 'daily_login', 'generation', etc.
            $table->unsignedBigInteger('source_id')->nullable(); // ID of the source (e.g., user_openai_id)
            $table->string('notification_type')->default('pending'); // 'pending', 'shown', 'dismissed'
            $table->text('message')->nullable(); // Custom message for notification
            $table->timestamp('notified_at')->nullable(); // When notification was shown
            $table->timestamps();
            
            $table->index(['user_id', 'notification_type']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_x_p_s');
    }
};
