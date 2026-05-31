<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('nom');
            $table->string('code')->nullable()->unique();
            $table->enum('type', ['pourcentage','montant_fixe','gratuit']);
            $table->decimal('valeur', 10, 2)->default(0);
            $table->decimal('minimum_achat', 10, 2)->default(0);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->integer('utilisations_max')->nullable();
            $table->integer('utilisations')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('promotions'); }
};