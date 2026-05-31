<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('magasin_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['entree','sortie','transfert','inventaire','retour']);
            $table->integer('quantite');
            $table->integer('stock_avant')->default(0);
            $table->integer('stock_apres')->default(0);
            $table->string('motif')->nullable();
            $table->string('reference')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('mouvements_stock'); }
};