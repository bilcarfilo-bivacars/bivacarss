<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->string('brand');
            $table->string('model');
            $table->smallInteger('year');
            $table->enum('transmission', ['automatic', 'manual']);
            $table->enum('fuel_type', ['gasoline', 'diesel', 'hybrid', 'electric', 'lpg', 'other'])->default('other');
            $table->integer('km');
            $table->string('plate')->nullable();
            $table->enum('listing_status', ['draft', 'pending_approval', 'active', 'rejected', 'archived'])->default('pending_approval');
            $table->decimal('listing_price_monthly', 12, 2)->nullable();
            $table->enum('listing_vat_mode', ['excluded', 'included'])->default('excluded');
            $table->decimal('base_price_daily', 12, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->dateTime('featured_until')->nullable();
            $table->decimal('custom_commission_rate', 5, 2)->nullable();
            $table->string('gps_provider')->nullable();
            $table->string('gps_external_id')->nullable();
            $table->string('gps_login_url')->nullable();
            $table->timestamps();

            $table->index('partner_id');
            $table->index('listing_status');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
