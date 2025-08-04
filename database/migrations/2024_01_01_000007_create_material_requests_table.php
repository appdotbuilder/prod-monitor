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
        Schema::create('material_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_step_id')->constrained('sample_steps');
            $table->foreignId('material_id')->constrained('materials');
            $table->decimal('quantity', 8, 2);
            $table->enum('source', ['warehouse', 'supplier', 'direct_purchase']);
            $table->enum('status', ['requested', 'sourcing', 'ordered', 'received'])->default('requested');
            $table->foreignId('requested_by')->constrained('users');
            $table->timestamp('requested_at');
            $table->timestamp('received_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['sample_step_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requests');
    }
};