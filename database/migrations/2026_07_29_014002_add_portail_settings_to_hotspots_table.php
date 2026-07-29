<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->string('couleur', 7)->default('#1ca04e')->after('description');
            $table->string('couleur_top', 7)->default('#110904')->after('couleur');
            $table->string('nom_portail', 100)->default('')->after('couleur_top');
            $table->text('message_bienvenue')->nullable()->after('nom_portail');
            $table->string('logo')->nullable()->after('message_bienvenue');
        });
    }

    public function down(): void
    {
        Schema::table('hotspots', function (Blueprint $table) {
            $table->dropColumn(['couleur', 'couleur_top', 'nom_portail', 'message_bienvenue', 'logo']);
        });
    }
};
