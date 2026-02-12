<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chatbot_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained('chatbot_flows')->cascadeOnDelete();
            $table->string('trigger');
            $table->longText('reply_text');
            $table->enum('reply_type', ['text', 'template', 'link'])->default('text');
            $table->longText('meta_json')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index(['flow_id', 'trigger']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_messages');
    }
};
