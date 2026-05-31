<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans');
            $table->string('nom');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->default('Sénégal');
            $table->string('devise')->default('FCFA');
            $table->string('logo')->nullable();
            $table->string('couleur_primaire')->default('#F5B72E');
            $table->string('couleur_secondaire')->default('#1A1A1A');
            $table->text('description')->nullable();
            $table->enum('statut', ['trial','active','suspended','cancelled'])->default('trial');
            $table->date('trial_fin')->nullable();
            $table->date('abonnement_debut')->nullable();
            $table->date('abonnement_fin')->nullable();
            $table->enum('periodicite', ['mensuel','annuel'])->default('mensuel');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('boutiques');
    }
};