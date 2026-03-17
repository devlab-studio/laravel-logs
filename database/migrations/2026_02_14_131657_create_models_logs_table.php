<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('models_logs', function (Blueprint $table) {
            $table->id();
            $table->string('procedure', 200)->index();
            $table->foreignId('procedure_id')->constrained('models_procedures');
            if (DB::getDriverName() !== 'sqlite') {
                $table->text('data')->fullText()->nullable();
            } else {
                $table->text('data')->nullable();
            }
            $table->timestamps();
            $table->foreignId('created_user')->index();
            $table->foreignId('updated_user')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models_logs');
    }
};
