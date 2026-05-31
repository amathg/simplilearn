<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sav', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vente_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->unique();
            $table->enum('type', ['retour','reparation','garantie','reclamation']);
            $table->string('produit_concerne');
            $table->text('description');
            $table->decimal('montant_avoir', 10, 2)->default(0);
            $table->enum('statut', ['ouvert','en_cours','resolu','ferme'])->default('ouvert');
            $table->date('date_garantie_fin')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sav'); }
};