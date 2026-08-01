<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotspot_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->cascadeOnDelete();
            $table->string('pack_key', 10);
            $table->unsignedInteger('slots')->default(0);
            $table->unsignedInteger('montant')->default(0);
            $table->enum('payment_method', ['ligdicash', 'solde'])->default('ligdicash');
            $table->timestamp('starts_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['vendeur_id', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspot_subscriptions');
    }
};
