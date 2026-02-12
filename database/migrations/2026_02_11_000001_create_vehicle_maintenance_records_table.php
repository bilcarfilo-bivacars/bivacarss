<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->enum('type', ['maintenance', 'insurance', 'mtv', 'tires', 'gps', 'other']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('cost_estimate', 12, 2)->nullable();
            $table->enum('status', ['open', 'done', 'cancelled'])->default('open');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->index(['vehicle_id', 'status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenance_records');
    }
};
