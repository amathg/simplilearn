<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nb_jours');
            $table->enum('type', ['annuel','maladie','maternite','sans_solde','autre']);
            $table->enum('statut', ['en_attente','approuve','refuse'])->default('en_attente');
            $table->text('motif')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('conges'); }
};