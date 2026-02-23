<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('corporate_leads')) {
            return;
        }

        Schema::table('corporate_leads', function (Blueprint $table): void {
            if (! Schema::hasColumn('corporate_leads', 'converted_to_lease_id')) {
                $table->unsignedBigInteger('converted_to_lease_id')->nullable()->after('status');
                $table->index('converted_to_lease_id');
            }
        });

        if (Schema::hasTable('corporate_leases') && Schema::hasColumn('corporate_leads', 'converted_to_lease_id')) {
            Schema::table('corporate_leads', function (Blueprint $table): void {
                $table->foreign('converted_to_lease_id')->references('id')->on('corporate_leases')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('corporate_leads') || ! Schema::hasColumn('corporate_leads', 'converted_to_lease_id')) {
            return;
        }

        Schema::table('corporate_leads', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('converted_to_lease_id');
        });
    }
};
