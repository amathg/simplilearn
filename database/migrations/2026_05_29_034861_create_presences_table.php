<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('heure_arrivee')->nullable();
            $table->time('heure_depart')->nullable();
            $table->enum('statut', ['present','absent','retard','conge','ferie'])->default('present');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('presences'); }
};