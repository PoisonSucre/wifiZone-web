<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('withdrawals');
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->restrictOnDelete();
            $table->decimal('montant_brut', 10, 2);
            $table->decimal('commission_pct', 5, 2);
            $table->decimal('montant_commission', 10, 2);
            $table->decimal('montant_net', 10, 2);
            $table->enum('statut', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->string('phone_number', 20)->nullable();
            $table->text('note')->nullable();
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_traitement')->nullable();
            $table->unsignedBigInteger('traite_par')->nullable();
            $table->timestamps();

            $table->index(['vendeur_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
