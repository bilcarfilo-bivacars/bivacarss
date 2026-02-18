<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporate_leads', function (Blueprint $table): void {
            $table->id();
            $table->string('company_name');
            $table->string('tax_number')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone');
            $table->string('contact_email')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('sector')->nullable();
            $table->integer('vehicles_needed')->nullable();
            $table->integer('lease_months')->nullable()->default(12);
            $table->decimal('budget_monthly', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->smallInteger('lead_score')->default(0);
            $table->enum('lead_grade', ['low', 'medium', 'high'])->default('low');
            $table->enum('status', ['new', 'contacted', 'qualified', 'won', 'lost'])->default('new');
            $table->dateTime('scored_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('lead_grade');
            $table->index('lead_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_leads');
    }
};
