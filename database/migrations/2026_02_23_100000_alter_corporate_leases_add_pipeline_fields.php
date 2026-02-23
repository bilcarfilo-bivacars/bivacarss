<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('corporate_leases')) {
            return;
        }

        Schema::table('corporate_leases', function (Blueprint $table): void {
            if (! Schema::hasColumn('corporate_leases', 'source_lead_id')) {
                $table->unsignedBigInteger('source_lead_id')->nullable()->after('created_by');
            }

            if (! Schema::hasColumn('corporate_leases', 'pipeline_stage')) {
                $table->enum('pipeline_stage', ['new', 'contacted', 'qualified', 'proposal_sent', 'won', 'lost'])
                    ->default('new')
                    ->after('source_lead_id');
            }

            if (! Schema::hasColumn('corporate_leases', 'matched_vehicle_id')) {
                $table->unsignedBigInteger('matched_vehicle_id')->nullable()->after('pipeline_stage');
            }
        });

        Schema::table('corporate_leases', function (Blueprint $table): void {
            if (Schema::hasColumn('corporate_leases', 'pipeline_stage')) {
                $table->index('pipeline_stage');
            }

            if (Schema::hasColumn('corporate_leases', 'source_lead_id')) {
                $table->index('source_lead_id');
            }

            if (Schema::hasColumn('corporate_leases', 'source_lead_id') && Schema::hasTable('corporate_leads')) {
                $table->foreign('source_lead_id')->references('id')->on('corporate_leads')->nullOnDelete();
            }

            if (Schema::hasColumn('corporate_leases', 'matched_vehicle_id') && Schema::hasTable('vehicles')) {
                $table->foreign('matched_vehicle_id')->references('id')->on('vehicles')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('corporate_leases')) {
            return;
        }

        Schema::table('corporate_leases', function (Blueprint $table): void {
            if (Schema::hasColumn('corporate_leases', 'source_lead_id')) {
                $table->dropConstrainedForeignId('source_lead_id');
            }

            if (Schema::hasColumn('corporate_leases', 'matched_vehicle_id')) {
                $table->dropConstrainedForeignId('matched_vehicle_id');
            }

            if (Schema::hasColumn('corporate_leases', 'pipeline_stage')) {
                $table->dropColumn('pipeline_stage');
            }
        });
    }
};
