<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partner_leads', function (Blueprint $table): void {
            $table->string('tax_number')->nullable()->after('phone');
            $table->tinyInteger('vehicles_count')->nullable()->after('km');
            $table->smallInteger('lead_score')->default(0)->after('status');
            $table->enum('lead_grade', ['low', 'medium', 'high'])->default('low')->after('lead_score');
            $table->dateTime('scored_at')->nullable()->after('lead_grade');

            $table->index('lead_grade');
            $table->index('lead_score');
        });
    }

    public function down(): void
    {
        Schema::table('partner_leads', function (Blueprint $table): void {
            $table->dropIndex(['lead_grade']);
            $table->dropIndex(['lead_score']);
            $table->dropColumn(['tax_number', 'vehicles_count', 'lead_score', 'lead_grade', 'scored_at']);
        });
    }
};
