<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('factures_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fournisseur_id')->constrained()->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('numero_facture')->nullable();
            $table->date('date_facture');
            $table->date('date_echeance')->nullable();
            $table->decimal('montant_ht', 10, 2)->default(0);
            $table->decimal('montant_tva', 10, 2)->default(0);
            $table->decimal('montant_ttc', 10, 2)->default(0);
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->enum('statut', ['en_attente','partielle','payee','annulee'])->default('en_attente');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('factures_fournisseurs'); }
};