<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('avances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->cascadeOnDelete();
            $table->decimal('montant', 10, 2);
            $table->date('date_avance');
            $table->enum('type', ['avance','prime','bonus']);
            $table->enum('statut', ['en_attente','approuve','rembourse'])->default('en_attente');
            $table->text('motif')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('avances'); }
};