<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_leads', function (Blueprint $table): void {
            $table->id();
            $table->string('full_name');
            $table->string('phone');
            $table->string('city')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->smallInteger('year')->nullable();
            $table->integer('km')->nullable();
            $table->decimal('expected_rent', 12, 2)->nullable();
            $table->boolean('has_damage')->default(false);
            $table->text('notes')->nullable();
            $table->string('photo_path')->nullable();
            $table->longText('calculation_json')->nullable();
            $table->enum('status', ['new', 'contacted', 'converted', 'archived'])->default('new');
            $table->timestamps();

            $table->index('status');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_leads');
    }
};
