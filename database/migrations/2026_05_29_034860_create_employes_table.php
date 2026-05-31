<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('matricule')->unique();
            $table->string('prenom');
            $table->string('nom');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('poste');
            $table->decimal('salaire_base', 10, 2)->default(0);
            $table->date('date_embauche');
            $table->enum('type_contrat', ['cdi','cdd','stage','freelance'])->default('cdi');
            $table->integer('conges_acquis')->default(0);
            $table->integer('conges_pris')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('employes'); }
};