<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('industries')) {
            Schema::create('industries', function (Blueprint $table): void {
                $table->id();
                $table->string('key')->unique();
                $table->string('name');
                $table->text('description')->nullable();
                $table->boolean('active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('city_industries')) {
            Schema::create('city_industries', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
                $table->foreignId('industry_id')->constrained('industries')->cascadeOnDelete();
                $table->boolean('active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();

                $table->unique(['city_id', 'industry_id']);
            });
        }

        if (Schema::hasTable('seo_pages')) {
            Schema::table('seo_pages', function (Blueprint $table): void {
                if (Schema::hasColumn('seo_pages', 'ref_type') && ! Schema::hasColumn('seo_pages', 'page_type')) {
                    $table->string('page_type')->nullable()->after('id');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('city_industries');
        Schema::dropIfExists('industries');
    }
};
