<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('corporate_models')) {
            Schema::create('corporate_models', function (Blueprint $table): void {
                $table->id();
                $table->string('brand');
                $table->string('model');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('km_packages')) {
            Schema::create('km_packages', function (Blueprint $table): void {
                $table->id();
                $table->unsignedInteger('km_limit');
                $table->decimal('yearly_price', 12, 2);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table): void {
                $table->id();
                $table->string('brand');
                $table->string('model');
                $table->unsignedSmallInteger('year')->nullable();
                $table->unsignedInteger('km')->nullable();
                $table->enum('listing_status', ['active', 'passive'])->default('active');
                $table->decimal('listing_price_monthly', 12, 2)->nullable();
                $table->boolean('is_featured')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('km_packages');
        Schema::dropIfExists('corporate_models');
    }
};
