<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket', function (Blueprint $table) {
            $table->foreignId('hotspot_id')->nullable()->constrained('hotspots')->nullOnDelete()->after('vendeur_id');
        });

        Schema::table('vendor_forfaits', function (Blueprint $table) {
            $table->foreignId('hotspot_id')->nullable()->constrained('hotspots')->cascadeOnDelete()->after('vendeur_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('hotspot_id')->nullable()->constrained('hotspots')->nullOnDelete()->after('vendeur_id');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreignId('hotspot_id')->nullable()->constrained('hotspots')->nullOnDelete()->after('vendeur_id');
        });

        Schema::table('import_batches', function (Blueprint $table) {
            $table->foreignId('hotspot_id')->nullable()->constrained('hotspots')->cascadeOnDelete()->after('vendeur_id');
        });
    }

    public function down(): void
    {
        Schema::table('ticket', fn(Blueprint $table) => $table->dropForeign(['hotspot_id']));
        Schema::table('ticket', fn(Blueprint $table) => $table->dropColumn('hotspot_id'));

        Schema::table('vendor_forfaits', fn(Blueprint $table) => $table->dropForeign(['hotspot_id']));
        Schema::table('vendor_forfaits', fn(Blueprint $table) => $table->dropColumn('hotspot_id'));

        Schema::table('transactions', fn(Blueprint $table) => $table->dropForeign(['hotspot_id']));
        Schema::table('transactions', fn(Blueprint $table) => $table->dropColumn('hotspot_id'));

        Schema::table('withdrawals', fn(Blueprint $table) => $table->dropForeign(['hotspot_id']));
        Schema::table('withdrawals', fn(Blueprint $table) => $table->dropColumn('hotspot_id'));

        Schema::table('import_batches', fn(Blueprint $table) => $table->dropForeign(['hotspot_id']));
        Schema::table('import_batches', fn(Blueprint $table) => $table->dropColumn('hotspot_id'));
    }
};
