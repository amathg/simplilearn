<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comptes_comptables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('numero', 20)->unique();
            $table->string('libelle');
            $table->enum('type', ['actif','passif','charge','produit','capitaux']);
            $table->foreignId('parent_id')->nullable()->constrained('comptes_comptables')->nullOnDelete();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('comptes_comptables'); }
};