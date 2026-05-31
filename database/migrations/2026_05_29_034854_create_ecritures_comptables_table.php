<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ecritures_comptables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('compte_id')->constrained('comptes_comptables')->cascadeOnDelete();
            $table->string('journal')->default('VE');
            $table->date('date_ecriture');
            $table->string('libelle');
            $table->decimal('debit', 10, 2)->default(0);
            $table->decimal('credit', 10, 2)->default(0);
            $table->string('reference')->nullable();
            $table->boolean('lettree')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ecritures_comptables'); }
};