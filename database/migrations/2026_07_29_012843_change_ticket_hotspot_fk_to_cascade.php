<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket', function (Blueprint $table) {
            $table->dropForeign(['hotspot_id']);
            $table->foreign('hotspot_id')->references('id')->on('hotspots')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ticket', function (Blueprint $table) {
            $table->dropForeign(['hotspot_id']);
            $table->foreign('hotspot_id')->references('id')->on('hotspots')->nullOnDelete();
        });
    }
};
