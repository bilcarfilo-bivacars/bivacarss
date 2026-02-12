<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('corporate_offers')) {
            return;
        }

        Schema::table('corporate_offers', function (Blueprint $table) {
            if (!Schema::hasColumn('corporate_offers', 'corporate_lease_id')) {
                $table->foreignId('corporate_lease_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('corporate_leases')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('corporate_offers') || !Schema::hasColumn('corporate_offers', 'corporate_lease_id')) {
            return;
        }

        Schema::table('corporate_offers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('corporate_lease_id');
        });
    }
};
