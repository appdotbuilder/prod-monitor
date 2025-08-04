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
        Schema::create('costings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained('worksheets');
            $table->decimal('material_cost', 10, 2)->default(0);
            $table->decimal('labor_cost', 10, 2)->default(0);
            $table->decimal('overhead_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->enum('approval_status', ['pending', 'production_approved', 'finance_approved', 'rejected'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('production_approved_by')->nullable()->constrained('users');
            $table->foreignId('finance_approved_by')->nullable()->constrained('users');
            $table->timestamp('production_approved_at')->nullable();
            $table->timestamp('finance_approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->integer('revision_number')->default(1);
            $table->timestamps();
            
            $table->index('approval_status');
            $table->index(['worksheet_id', 'revision_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costings');
    }
};