<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transferts_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('magasin_source_id')->constrained('magasins')->cascadeOnDelete();
            $table->foreignId('magasin_destination_id')->constrained('magasins')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->enum('statut', ['en_attente','expedie','recu','annule'])->default('en_attente');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('transferts_stock_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfert_id')->constrained('transferts_stock')->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->integer('quantite');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('transferts_stock_lignes');
        Schema::dropIfExists('transferts_stock');
    }
};