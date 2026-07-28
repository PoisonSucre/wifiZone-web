<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('import_batches');
        Schema::create('import_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->cascadeOnDelete();
            $table->string('filename', 255);
            $table->enum('format_file', ['csv', 'excel']);
            $table->integer('total_tickets')->default(0);
            $table->timestamp('imported_at')->useCurrent();
            $table->enum('statut', ['success', 'partial', 'error'])->default('success');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_batches');
    }
};
