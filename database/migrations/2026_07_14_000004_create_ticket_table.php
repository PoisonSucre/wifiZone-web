<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('ticket');
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->restrictOnDelete();
            $table->string('user', 255);
            $table->string('password', 255);
            $table->string('forfait', 50)->nullable();
            $table->integer('montant')->default(0);
            $table->string('token', 500)->nullable();
            $table->enum('status', ['disponible', 'vendu'])->default('disponible');
            $table->string('mikrotik_id', 50)->nullable();
            $table->enum('source', ['api', 'import', 'manual', 'mikrotik'])->default('manual');
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();

            $table->index(['vendeur_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
