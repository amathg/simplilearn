<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained('boutiques')->cascadeOnDelete();
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix_vente', 10, 2)->default(0);
            $table->decimal('prix_achat', 10, 2)->default(0);
            $table->unsignedTinyInteger('promo')->default(0);
            $table->integer('stock_alerte')->default(5);
            $table->string('icone')->default('ti-package');
            $table->string('image')->nullable();
            $table->boolean('nouveau')->default(false);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('produits'); }
};