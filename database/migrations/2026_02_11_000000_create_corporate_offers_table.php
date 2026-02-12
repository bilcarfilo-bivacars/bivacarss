<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corporate_offers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('brand');
            $table->string('model');
            $table->foreignId('km_package_id')->constrained('km_packages');
            $table->decimal('monthly_price', 12, 2);
            $table->decimal('vat_rate', 5, 2)->default(20.00);
            $table->text('notes')->nullable();
            $table->string('pdf_path')->nullable();
            $table->enum('status', ['draft', 'generated', 'sent'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_offers');
    }
};
