<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('vendeurs');
        Schema::create('vendeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 255)->unique();
            $table->string('telephone', 20);
            $table->string('password', 255);
            $table->string('adresse', 255)->nullable();
            $table->string('ville', 100)->nullable();
            $table->enum('statut', ['actif', 'suspendu', 'en_attente'])->default('en_attente');
            $table->decimal('commission_pct', 5, 2)->default(10.00);
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamp('last_login')->nullable();
            $table->string('couleur', 7)->default('#1ca04e');
            $table->string('logo', 255)->nullable();
            $table->text('message_bienvenue')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendeurs');
    }
};
