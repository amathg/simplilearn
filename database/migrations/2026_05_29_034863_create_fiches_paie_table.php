<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fiches_paie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->cascadeOnDelete();
            $table->integer('mois');
            $table->integer('annee');
            $table->decimal('salaire_base', 10, 2);
            $table->decimal('primes', 10, 2)->default(0);
            $table->decimal('heures_sup', 10, 2)->default(0);
            $table->decimal('avances_deduites', 10, 2)->default(0);
            $table->decimal('cotisations', 10, 2)->default(0);
            $table->decimal('net_a_payer', 10, 2);
            $table->enum('statut', ['brouillon','valide','paye'])->default('brouillon');
            $table->date('date_paiement')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('fiches_paie'); }
};