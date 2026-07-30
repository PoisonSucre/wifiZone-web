<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->index('statut', 'idx_vendeurs_statut');
            $table->index('date_inscription', 'idx_vendeurs_date_inscription');
        });

        Schema::table('ticket', function (Blueprint $table) {
            $table->index('status', 'idx_ticket_status');
            $table->index('date_creation', 'idx_ticket_date_creation');
            $table->index('forfait', 'idx_ticket_forfait');
            $table->index('token', 'idx_ticket_token');
            $table->index('vendeur_id', 'idx_ticket_vendeur_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('statut', 'idx_transactions_statut');
            $table->index('date_creation', 'idx_transactions_date_creation');
            $table->index('vendeur_id', 'idx_transactions_vendeur_id');
            $table->index('transaction_id', 'idx_transactions_transaction_id');
            $table->index('token', 'idx_transactions_token');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->index('statut', 'idx_withdrawals_statut');
            $table->index('date_creation', 'idx_withdrawals_date_creation');
            $table->index('vendeur_id', 'idx_withdrawals_vendeur_id');
        });

        Schema::table('vendor_forfaits', function (Blueprint $table) {
            $table->index('vendeur_id', 'idx_vendor_forfaits_vendeur_id');
        });

        Schema::table('import_batches', function (Blueprint $table) {
            $table->index('vendeur_id', 'idx_import_batches_vendeur_id');
        });
    }

    public function down(): void
    {
        Schema::table('vendeurs', function (Blueprint $table) {
            $table->dropIndex('idx_vendeurs_statut');
            $table->dropIndex('idx_vendeurs_date_inscription');
        });

        Schema::table('ticket', function (Blueprint $table) {
            $table->dropIndex('idx_ticket_status');
            $table->dropIndex('idx_ticket_date_creation');
            $table->dropIndex('idx_ticket_forfait');
            $table->dropIndex('idx_ticket_token');
            $table->dropIndex('idx_ticket_vendeur_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_statut');
            $table->dropIndex('idx_transactions_date_creation');
            $table->dropIndex('idx_transactions_vendeur_id');
            $table->dropIndex('idx_transactions_transaction_id');
            $table->dropIndex('idx_transactions_token');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropIndex('idx_withdrawals_statut');
            $table->dropIndex('idx_withdrawals_date_creation');
            $table->dropIndex('idx_withdrawals_vendeur_id');
        });

        Schema::table('vendor_forfaits', function (Blueprint $table) {
            $table->dropIndex('idx_vendor_forfaits_vendeur_id');
        });

        Schema::table('import_batches', function (Blueprint $table) {
            $table->dropIndex('idx_import_batches_vendeur_id');
        });
    }
};
