<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cartes_fidelite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('numero')->unique();
            $table->integer('points')->default(0);
            $table->decimal('valeur_point', 5, 2)->default(1);
            $table->enum('niveau', ['bronze','argent','or','platine'])->default('bronze');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::create('points_fidelite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carte_id')->constrained('cartes_fidelite')->cascadeOnDelete();
            $table->integer('points');
            $table->enum('type', ['gain','utilisation','expiration']);
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('points_fidelite');
        Schema::dropIfExists('cartes_fidelite');
    }
};