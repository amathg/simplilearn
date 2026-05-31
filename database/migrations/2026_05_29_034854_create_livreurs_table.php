<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('livreurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('prenom');
            $table->string('nom');
            $table->string('telephone');
            $table->string('vehicule')->nullable();
            $table->string('zone')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('immatriculation')->unique();
            $table->string('marque');
            $table->string('modele')->nullable();
            $table->enum('type', ['moto','voiture','camion','velo'])->default('moto');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('vehicules');
        Schema::dropIfExists('livreurs');
    }
};