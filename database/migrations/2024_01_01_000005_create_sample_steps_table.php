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
        Schema::create('sample_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_id')->constrained('samples');
            $table->enum('step_type', ['material_preparation', 'pattern_data', 'cutting', 'application', 'sewing', 'finishing', 'qa']);
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed'])->default('pending');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->json('step_data')->nullable()->comment('Additional data specific to each step type');
            $table->timestamps();
            
            $table->index(['sample_id', 'step_type']);
            $table->index('status');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_steps');
    }
};