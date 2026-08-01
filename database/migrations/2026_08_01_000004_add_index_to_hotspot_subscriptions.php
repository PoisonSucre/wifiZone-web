<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotspot_subscriptions', function (Blueprint $table) {
            $table->index(['vendeur_id', 'frozen_at', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::table('hotspot_subscriptions', function (Blueprint $table) {
            $table->dropIndex(['vendeur_id', 'frozen_at', 'expires_at']);
        });
    }
};