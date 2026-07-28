<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('transactions');
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->restrictOnDelete();
            $table->string('token', 500)->nullable();
            $table->string('transaction_id', 50)->nullable();
            $table->integer('montant')->default(0);
            $table->string('statut', 50)->default('pending');
            $table->foreignId('ticket_id')->nullable()->constrained('ticket')->nullOnDelete();
            $table->string('phone_number', 50)->nullable();
            $table->string('verification_status', 50)->nullable();
            $table->decimal('commission', 10, 2)->default(0);
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();

            $table->index(['vendeur_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
