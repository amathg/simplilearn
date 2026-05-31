<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories_depenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('nom');
            $table->string('icone')->default('ti-receipt');
            $table->timestamps();
        });

        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categorie_id')->nullable()->constrained('categories_depenses')->nullOnDelete();
            $table->string('libelle');
            $table->decimal('montant', 10, 2);
            $table->date('date_depense');
            $table->string('mode_paiement')->default('especes');
            $table->string('reference')->nullable();
            $table->string('justificatif')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('depenses');
        Schema::dropIfExists('categories_depenses');
    }
};