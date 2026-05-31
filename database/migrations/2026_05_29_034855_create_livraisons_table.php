<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('livreur_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vehicule_id')->nullable()->constrained()->nullOnDelete();
            $table->string('adresse_livraison');
            $table->decimal('frais_livraison', 10, 2)->default(0);
            $table->enum('statut', ['en_attente','assignee','en_cours','livree','echouee','annulee'])->default('en_attente');
            $table->dateTime('date_prevue')->nullable();
            $table->dateTime('date_livraison')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('livraisons'); }
};