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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained('worksheets');
            $table->foreignId('costing_id')->constrained('costings');
            $table->string('sample_code')->unique();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'qa_passed', 'qa_failed'])->default('pending');
            $table->foreignId('assigned_team_id')->nullable()->constrained('teams');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('sample_code');
            $table->index('status');
            $table->index(['worksheet_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};