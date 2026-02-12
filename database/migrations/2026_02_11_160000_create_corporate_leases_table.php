<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('corporate_leases')) {
            return;
        }

        Schema::create('corporate_leases', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->foreignId('corporate_model_id')->nullable()->constrained('corporate_models')->nullOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('km_package_id')->constrained('km_packages')->cascadeOnDelete();
            $table->decimal('monthly_price', 12, 2);
            $table->decimal('vat_rate', 5, 2)->default(20.00);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft', 'active', 'ended', 'cancelled'])->default('draft');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_leases');
    }
};
