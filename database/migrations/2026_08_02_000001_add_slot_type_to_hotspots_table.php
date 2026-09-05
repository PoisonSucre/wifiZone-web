<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('hotspots', 'slot_type')) {
            Schema::table('hotspots', function (Blueprint $table) {
                $table->enum('slot_type', ['gratuit', 'abonnement'])->default('gratuit')->after('statut');
            });
        }

        $freeSlots = (int) DB::table('settings')->where('setting_key', 'hotspot_free_slots')->value('setting_value');
        $freeSlots = max(0, $freeSlots);

        $vendeurIds = DB::table('hotspots')->select('vendeur_id')->distinct()->pluck('vendeur_id');

        foreach ($vendeurIds as $vendeurId) {
            $ids = DB::table('hotspots')
                ->where('vendeur_id', $vendeurId)
                ->orderBy('created_at')
                ->orderBy('id')
                ->pluck('id');

            foreach ($ids->take($freeSlots) as $id) {
                DB::table('hotspots')->where('id', $id)->update(['slot_type' => 'gratuit']);
            }
            foreach ($ids->slice($freeSlots) as $id) {
                DB::table('hotspots')->where('id', $id)->update(['slot_type' => 'abonnement']);
            }
        }
    }

    public function down(): void
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->dropColumn('slot_type');
        });
    }
};
