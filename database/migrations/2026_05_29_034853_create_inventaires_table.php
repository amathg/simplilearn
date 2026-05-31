<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('magasin_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference')->unique();
            $table->enum('statut', ['brouillon','en_cours','valide','annule'])->default('brouillon');
            $table->date('date_inventaire');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('inventaire_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaire_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->integer('stock_theorique')->default(0);
            $table->integer('stock_reel')->default(0);
            $table->integer('ecart')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('inventaire_lignes');
        Schema::dropIfExists('inventaires');
    }
};