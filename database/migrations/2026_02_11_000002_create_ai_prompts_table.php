<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_prompts', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->longText('system_prompt');
            $table->longText('user_prompt_template');
            $table->string('model')->default('gpt-4.1-mini');
            $table->decimal('temperature', 3, 2)->default(0.70);
            $table->integer('max_tokens')->default(1200);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_prompts');
    }
};
