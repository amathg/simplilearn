<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('retours_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fournisseur_id')->constrained()->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->date('date_retour');
            $table->enum('motif', ['defectueux','erreur_livraison','qualite','autre']);
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->enum('statut', ['en_attente','accepte','refuse','rembourse'])->default('en_attente');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('retours_fournisseurs_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retour_id')->constrained('retours_fournisseurs')->cascadeOnDelete();
            $table->foreignId('produit_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nom_produit');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('retours_fournisseurs_lignes');
        Schema::dropIfExists('retours_fournisseurs');
    }
};