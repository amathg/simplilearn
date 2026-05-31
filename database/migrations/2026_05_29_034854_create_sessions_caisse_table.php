<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('sessions_caisse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('magasin_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->dateTime('ouverture_at');
            $table->dateTime('fermeture_at')->nullable();
            $table->decimal('fond_ouverture', 10, 2)->default(0);
            $table->decimal('fond_fermeture', 10, 2)->nullable();
            $table->decimal('total_especes', 10, 2)->default(0);
            $table->decimal('total_carte', 10, 2)->default(0);
            $table->decimal('total_mobile', 10, 2)->default(0);
            $table->decimal('total_credit', 10, 2)->default(0);
            $table->decimal('total_ventes', 10, 2)->default(0);
            $table->enum('statut', ['ouverte','fermee'])->default('ouverte');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('sessions_caisse'); }
};