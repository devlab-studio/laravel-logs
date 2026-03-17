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
        Schema::create('logs_audits', function (Blueprint $table) {
            $table->id();
            $table->string('site', 75)->index();
            $table->string('topic', 75)->index();
            $table->json('data')->nullable();
            $table->text('url')->nullable();
            $table->string('host', 75)->index();
            $table->string('ip', 75)->nullable()->index();
            $table->text('referer')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_audits');
    }
};
