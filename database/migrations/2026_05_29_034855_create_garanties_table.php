<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('garanties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->integer('duree_mois')->default(12);
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('conditions')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('garanties'); }
};