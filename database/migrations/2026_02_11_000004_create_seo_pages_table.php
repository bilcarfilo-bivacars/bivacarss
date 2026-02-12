<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->enum('page_type', ['city', 'district', 'point']);
            $table->unsignedBigInteger('ref_id');
            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->text('meta_description')->nullable();
            $table->longText('content')->nullable();
            $table->longText('faq_json')->nullable();
            $table->longText('schema_override')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['page_type', 'ref_id']);
            $table->index(['page_type', 'ref_id', 'updated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
