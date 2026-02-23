<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('region_group')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('districts')) {
            Schema::create('districts', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
                $table->string('name');
                $table->string('slug');
                $table->timestamps();

                $table->unique(['city_id', 'slug']);
            });
        }

        if (! Schema::hasTable('location_points')) {
            Schema::create('location_points', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
                $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
                $table->string('name');
                $table->string('slug');
                $table->string('type');
                $table->timestamps();

                $table->unique(['city_id', 'slug']);
            });
        }

        if (! Schema::hasTable('seo_pages')) {
            Schema::create('seo_pages', function (Blueprint $table): void {
                $table->id();
                $table->enum('page_type', ['city', 'district', 'point', 'industry', 'city_industry']);
                $table->unsignedBigInteger('ref_id');
                $table->string('locale', 10)->default('tr');
                $table->string('slug')->nullable();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->longText('content')->nullable();
                $table->json('faq_json')->nullable();
                $table->longText('schema_override')->nullable();
                $table->timestamps();

                $table->unique(['page_type', 'ref_id', 'locale']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
        Schema::dropIfExists('location_points');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
    }
};
