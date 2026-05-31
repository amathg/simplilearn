<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ventes_credit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->decimal('montant_total', 10, 2);
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->decimal('montant_restant', 10, 2);
            $table->date('date_echeance')->nullable();
            $table->enum('statut', ['en_cours','solde','en_retard'])->default('en_cours');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('paiements_credit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_credit_id')->constrained('ventes_credit')->cascadeOnDelete();
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement')->default('especes');
            $table->date('date_paiement');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('paiements_credit');
        Schema::dropIfExists('ventes_credit');
    }
};