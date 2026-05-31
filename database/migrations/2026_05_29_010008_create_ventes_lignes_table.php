<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ventes_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_id')->constrained('ventes')->cascadeOnDelete();
            $table->foreignId('produit_id')->nullable()->constrained('produits')->nullOnDelete();
            $table->string('nom_produit');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('tva', 5, 2)->default(0);
            $table->decimal('remise', 5, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ventes_lignes'); }
};